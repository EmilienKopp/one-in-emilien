// place files you want to import through the `$lib` alias in this folder.
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
  }
  
  export interface ShowcaseSite {
    title: string;
    image: any;
    url: string;
    tags: string[];
  }
  