import { Component, signal } from '@angular/core';
import { Router } from '@angular/router';
import { CommonModule } from '@angular/common';
import { inject } from '@angular/core';

@Component({
  selector: 'app-inscription-identite',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './inscription-identite.component.html',
})
export class InscriptionIdentiteComponent {
  private router = inject(Router);
  roleChoisi = signal<'client' | 'tailleur' | null>(null);

  choisir(role: 'client' | 'tailleur'): void {
    this.roleChoisi.set(role);
  }

  continuer(): void {
    if (this.roleChoisi() === 'client')   this.router.navigate(['/inscription/client']);
    if (this.roleChoisi() === 'tailleur') this.router.navigate(['/inscription/tailleur']);
  }
}
