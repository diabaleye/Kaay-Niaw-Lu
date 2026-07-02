import { Component, inject, signal } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ReactiveFormsModule, FormBuilder, Validators } from '@angular/forms';
import { RouterLink } from '@angular/router';
import { AuthService } from '../../../core/services/auth.service';

@Component({
  selector: 'app-connexion',
  standalone: true,
  imports: [CommonModule, ReactiveFormsModule, RouterLink],
  templateUrl: './connexion.component.html',
})
export class ConnexionComponent {
  private fb   = inject(FormBuilder);
  private auth = inject(AuthService);

  chargement  = signal(false);
  erreur      = signal<string | null>(null);
  motDePasseVisible = signal(false);

  form = this.fb.group({
    telephone: ['', [Validators.required]],
    password:  ['', [Validators.required]],
  });

  get tel() { return this.form.get('telephone')!; }
  get mdp() { return this.form.get('password')!; }

  soumettre(): void {
    if (this.form.invalid) { this.form.markAllAsTouched(); return; }

    this.chargement.set(true);
    this.erreur.set(null);

    this.auth.connecter(this.form.value as any).subscribe({
      next: () => this.auth.redirigerSelonRole(),
      error: (err) => {
        this.chargement.set(false);
        this.erreur.set(
          err.error?.errors?.telephone?.[0] ??
          err.error?.message ??
          'Une erreur est survenue.'
        );
      },
    });
  }
}
