// Type definitions for portfolio components
export interface ContentSectionProps {
    id: string;
    title: string;
}

export interface CompatibilityItem {
    icon: string;
    title: string;
    url: string;
}

export interface FeatureItem {
    description: string;
    icon: string;
    title: string;
    pack: string;
}

export interface FooterLink {
    description: string;
    icon: string;
    pack: string;
    url: string;
}

export interface NavItem {
    title: string;
    url: string;
    external?: boolean;
}

export interface ShowcaseSite {
    title: string;
    image: any;
    url: string;
    actions?: NavItem[];
    tags: string[];
    personal?: boolean;
    client?: string;
    description?: string;
    responsibilities?: string[];
}
