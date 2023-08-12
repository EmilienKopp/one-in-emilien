import { z } from 'zod';

export const loginSchema = z.object({
    email: z.string().email(),
    password: z.string().min(6).max(100),
});

export type LoginCredentials = z.infer<typeof loginSchema>;

export const availabilitySchema = z.object({
    id: z.string(),
    monday: z.number().default(0),
    tuesday: z.number().default(0),
    wednesday: z.number().default(0),
    thursday: z.number().default(0),
    friday: z.number().default(0),
    saturday: z.number().default(0),
    sunday: z.number().default(0),
    off_from: z.date(),
    off_to: z.date(),
    available_now: z.boolean().default(true),
    weekly_average: z.number().default(0),
});

export type Availability = z.infer<typeof availabilitySchema>;

