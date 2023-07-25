import { pgTable, serial, text, timestamp, varchar } from "drizzle-orm/pg-core";

export const inquiries = pgTable("inquiries", {
    id: serial('id').primaryKey(),
    customerName: text('customer_name'),
    companyName: text('company_name'),
    email: text('email'),
    message: text('message'),
    inquiry: text('inquiry'),
    createdAt: timestamp('created_at'),
});