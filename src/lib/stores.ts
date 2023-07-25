import { derived, writable, type Writable } from "svelte/store";
import { page } from "$app/stores";

export const typingBlockContent: Writable<string> = writable("");

export const chatting: Writable<boolean> = writable(false);

export const scrolled: Writable<boolean> = writable(false);

export const theme: Writable<"light" | "dark"> = writable("light");

export const navPosition: Writable<"top" | "bottom"> = writable("bottom");

export const commandsVisible: Writable<boolean> = writable(false);
