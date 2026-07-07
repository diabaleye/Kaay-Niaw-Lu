import { Component } from '@angular/core';
import { RouterLink, RouterLinkActive } from '@angular/router';
import { LogoComponent } from '../logo/logo.component';

@Component({
  selector: 'app-sidebar-client',
  imports: [RouterLink, RouterLinkActive, LogoComponent],
  templateUrl: './sidebar-client.component.html',
  styleUrl: './sidebar-client.component.css'
})
export class SidebarClientComponent {
  menuItems = [
    { path: '/client/tableau-de-bord', label: 'Tableau de bord', icon: '▦' },
    { path: '/client/mesures', label: 'Carnet de mesures', icon: '△' },
    { path: '/client/commandes', label: 'Historique des commandes', icon: '⌁' },
    { path: '/client/messagerie', label: 'Ma messagerie', icon: '💬' },
    { path: '/client/parametres', label: 'Paramètres', icon: '⚙' }
  ];
}
