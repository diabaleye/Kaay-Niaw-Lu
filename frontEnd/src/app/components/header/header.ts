import { Component, Input } from '@angular/core';

@Component({
  selector: 'app-header',
  standalone: true,
  imports: [],
  templateUrl: './header.html',
  styleUrl: './header.css'
})
export class Header {
  @Input() titre: string = '';

  onNotifClick() {
    console.log('Notifications cliquées');
  }

  onProfilClick() {
    console.log('Profil cliqué');
  }
}