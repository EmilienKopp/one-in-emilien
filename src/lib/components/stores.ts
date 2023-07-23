import { writable } from "svelte/store";

export const typingBlockContent = writable("");

export const chatting = writable(false);

export const scrolled = writable(false);
