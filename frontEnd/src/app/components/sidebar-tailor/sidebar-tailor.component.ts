import { Component } from '@angular/core';
import { RouterLink, RouterLinkActive } from '@angular/router';
import { LogoComponent } from '../logo/logo.component';

@Component({
  selector: 'app-sidebar-tailor',
  imports: [RouterLink, RouterLinkActive, LogoComponent],
  templateUrl: './sidebar-tailor.component.html',
  styleUrl: './sidebar-tailor.component.css'
})
export class SidebarTailorComponent {
  menuItems = [
    { path: '/tailleur/tableau-de-bord', label: 'Tableau de bord', icon: '▦' },
    { path: '/tailleur/commandes', label: 'Commandes reçues', icon: '△' },
    { path: '/tailleur/calendrier', label: 'Calendrier des livraisons', icon: '⌁' },
    { path: '/tailleur/atelier', label: 'Mon atelier virtuel', icon: '▣' },
    { path: '/tailleur/messagerie', label: 'Ma messagerie', icon: '💬' },
    { path: '/tailleur/parametres', label: 'Paramètres', icon: '⚙' }
  ];
}
