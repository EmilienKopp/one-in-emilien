import { derived, writable, type Writable } from "svelte/store";
import { page } from "$app/stores";

export const typingBlockContent = writable("");

export const chatting = writable(false);

export const scrolled = writable(false);

export const theme: Writable<"light" | "dark"> = writable("light");

export const navPosition: Writable<"top" | "bottom"> = writable("bottom");
