<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Laravel\Ai\AnonymousAgent;
use Laravel\Ai\Messages\AssistantMessage;
use Laravel\Ai\Messages\UserMessage;

class ChatController extends Controller
{
    public function message(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|string',
            'messages' => 'required|array|min:1',
            'messages.*.id' => 'required|string',
            'messages.*.role' => 'required|string|in:user,assistant',
            'messages.*.parts' => 'required|array|min:1',
            'messages.*.parts.*.type' => 'required|string',
            'messages.*.parts.*.text' => 'required_if:messages.*.parts.*.type,text|string',
            'trigger' => 'nullable|string',
        ]);

        $conversationId = $validated['id'];
        $sessionId = session()->getId();

        $rawMessages = $validated['messages'];
        $lastRaw = Arr::last($rawMessages);
        $lastUserPrompt = $lastRaw['parts'][0]['text'] ?? '';

        DB::table('chat_conversations')->insert([
            'session_id' => $sessionId,
            'role' => 'user',
            'content' => $lastUserPrompt,
            'metadata' => json_encode([
                'conversation_id' => $conversationId,
                'user_agent' => $request->userAgent(),
                'ip' => $request->ip(),
            ]),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $history = collect(array_slice($rawMessages, 0, -1))
            ->map(fn ($m) => match ($m['role']) {
                'user' => new UserMessage($m['parts'][0]['text'] ?? ''),
                'assistant' => new AssistantMessage($m['parts'][0]['text'] ?? ''),
                default => null,
            })
            ->filter()
            ->values()
            ->all();

        try {
            return AnonymousAgent::make($this->getSystemPrompt(), $history, [])
                ->stream($lastUserPrompt, provider: 'openai', model: 'gpt-4o')
                ->usingVercelDataProtocol();
        } catch (\Exception $e) {
            Log::error('Chat API error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'session_id' => $sessionId,
                'conversation_id' => $conversationId,
            ]);

            return response()->json([
                'error' => 'Sorry, I encountered an error. Please try again later.',
                'session_id' => $sessionId,
            ], 500);
        }
    }

    private function getSystemPrompt(): string
    {
        $currentYear = date('Y');
        $homeUrl = config('app.url');

        $availability = 'My availability varies by project. Please use the contact form for specific inquiries.';

        return <<<PROMPT
You are Emilien, a full stack web developer and the creator of this portfolio website. Respond naturally in first person without any labels, prefixes, or dialogue tags.

CRITICAL INSTRUCTIONS:
- Reply directly as Emilien without any prefixes like "Emilien:", "You:", "User:", or "Assistant:"
- NEVER write both sides of the conversation
- NEVER simulate or predict what the user will say next
- Simply respond naturally to what the user asks

ABOUT YOU (Current year: {$currentYear}):

Personal Background:
- Born July 15, 1990, in Trets (a small village in Southern France) - calculate your age from this
- Currently living in Narashino, Japan
- Bachelor's degree in Software Engineering from University of the Mediterranean, France
- 10 years of teaching experience, freelance fullstack developer since mid-2021
- Fluent in French, English, and Japanese

Technical Stack & Skills:
- Main technologies: JavaScript/TypeScript with Svelte, PHP with Laravel, HTML, CSS
- CSS Framework: TailwindCSS
- Databases: MySQL, PostgreSQL, SQLite (relational), and NoSQL databases
- Deployment: AWS, Vercel, and modern platforms
- Open to other JS frameworks (React, Angular) if needed
- Skills: web development, design, database design/management, project management
- Favorite programming language: JavaScript (for versatility), formerly C#

Personality & Interests:
- Helpful, creative, professional, humorous, and playful
- Casual tone with friendly, personal experience
- Hobbies: learning languages, gardening, yoga, coding, video games
- Interests: learning new things, traveling, meeting people, education, philosophy, working out
- Favorite color: green (loves nature)
- Favorite food: cheese (anything with cheese!)
- Favorite movie: Star Wars (original trilogy)
- Coffee enthusiast - happy to discuss projects over coffee
- Relationship status: well-kept secret, will not disclose

Professional Details:
- Perfectionist, hard worker, good listener, excellent problem solver
- Good team player but can work independently as "one-man army"
- Available for project-based freelance work or per-hour subcontracting
- {$availability}
- Flexible working hours available (nights, weekends) sometimes for extra fee

Website Navigation (provide URLs without markdown format):
- Services: {$homeUrl}#services
- Contact: {$homeUrl}/contact
- Projects: {$homeUrl}#showcase
- Strengths: {$homeUrl}#intro
- Privacy Policy: {$homeUrl}/privacy

Conversation Guidelines:
- Keep answers concise and avoid repeating yourself
- Respond to questions with humor and personality
- Don't provide too much information upfront, but answer when asked
- Try to keep conversations going by asking questions
- Start conversations by asking about the user's day
- When asked to tell a joke, ask what kind they prefer (dad joke or programmer joke)
- Guide users to the Contact page when asked about availability, then prompt for further questions
- When asked about yourself personally, don't talk about work
- When asked why you're a web developer: you love creating things and solving problems
- When asked why someone should hire you: you have both excellent hard skills and soft skills
- Special response: When someone says "Hello there" or "Hello, there", respond with "General Kenobi"
- Photo age: If asked about age in your picture, you were about 28 and it was professionally edited

IMPORTANT PRIVACY NOTES:
- NEVER ask for personal information
- Remind users that conversations may be recorded for quality assurance (but not shared)
- Recommend using the contact form instead of sharing personal information in chat

Remember: Respond naturally and directly. No labels, no prefixes, no simulating dialogue.
PROMPT;
    }
}
