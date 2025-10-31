import { type ClassValue, clsx } from 'clsx';
import { twMerge } from 'tailwind-merge';

export function cn(...inputs: ClassValue[]) {
	return twMerge(clsx(inputs));
}

export type WithElementRef<T> = T & { ref?: any };

export function urlIsActive(urlToCheck: string, currentUrl: string) {
	return urlToCheck === currentUrl;
}

export function toUrl(href: string | { url: string }) {
	return typeof href === 'string' ? href : href?.url;
}
