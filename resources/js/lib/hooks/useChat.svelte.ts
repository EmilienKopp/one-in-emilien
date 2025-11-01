interface Message {
    role: 'user' | 'assistant';
    content: string;
}

class ChatHandler {
    messages: Array<Message> = $state([]);
    #eventSource: EventSource | null = null;

    constructor() {}

    [Symbol.dispose]() {
        this.#eventSource?.close();
    }

    addMessage(message: any) {
        this.messages.push(message);
        this.createEventSource();
    }

    onComplete(callback: () => void) {
        this.#eventSource?.addEventListener('stream_end', () => {
            callback();
        });
    }

    getMessages() {
        return this.messages;
    }

    private createEventSource() {
        if (this.#eventSource) {
            this.#eventSource.close();
        }

        this.#eventSource = new EventSource('/api/chat');
        this.#eventSource.addEventListener(
            'text_delta',
            this.handleDelta.bind(this),
        );

        this.#eventSource.addEventListener(
            'stream_end',
            this.handleStreamEnd.bind(this),
        );
    }

    private handleDelta(event: any) {
        const data = JSON.parse(event.data);
        if (this.messages.at(-1)?.role !== 'assistant') {
            this.messages.push({ role: 'assistant', content: '' });
        }
        this.messages.at(-1)!.content += data.delta;
        console.log('Received delta:', data.delta);
    }

    private handleStreamEnd(event: any) {
        const data = JSON.parse(event.data);
        console.log('Stream ended:', data.finish_reason);
        this.#eventSource?.close();
    }
}

export const useChat = () => {
    const chatHandler = new ChatHandler();

    return chatHandler;
};
