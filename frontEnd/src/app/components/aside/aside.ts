import { Component } from '@angular/core';
import { RouterLink, RouterLinkActive, Router } from '@angular/router';

@Component({
  selector: 'app-aside',
  standalone: true,
  imports: [RouterLink, RouterLinkActive],
  templateUrl: './aside.html',
  styleUrl: './aside.css'
})
export class Aside {
  constructor(private router: Router) {}

  onDeconnexion(event: Event) {
    event.preventDefault();
    console.log('Déconnexion...');
    // Plus tard : appel au service d'authentification Laravel
    this.router.navigate(['/login']);
  }
}