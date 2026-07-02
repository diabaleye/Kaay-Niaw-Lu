import { Component, inject, signal } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ReactiveFormsModule, FormBuilder, Validators, AbstractControl, ValidationErrors } from '@angular/forms';
import { RouterLink } from '@angular/router';
import { AuthService } from '../../../core/services/auth.service';

function confirmerMotDePasse(control: AbstractControl): ValidationErrors | null {
  const mdp     = control.get('password');
  const confirm = control.get('password_confirmation');
  if (mdp && confirm && mdp.value !== confirm.value) {
    confirm.setErrors({ nonCorrespondant: true });
    return { nonCorrespondant: true };
  }
  return null;
}

@Component({
  selector: 'app-inscription-client',
  standalone: true,
  imports: [CommonModule, ReactiveFormsModule, RouterLink],
  templateUrl: './inscription-client.component.html',
})
export class InscriptionClientComponent {
  private fb   = inject(FormBuilder);
  private auth = inject(AuthService);

  chargement = signal(false);
  erreurs    = signal<Record<string, string[]>>({});

  form = this.fb.group({
    prenom:               ['', [Validators.required, Validators.maxLength(100)]],
    nom:                  ['', [Validators.required, Validators.maxLength(100)]],
    email:                ['', [Validators.required, Validators.email]],
    telephone:            ['', [Validators.required]],
    password:             ['', [Validators.required, Validators.minLength(8)]],
    password_confirmation:['', [Validators.required]],
  }, { validators: confirmerMotDePasse });

  f(name: string) { return this.form.get(name)!; }
  erreur(name: string): string | null {
    const ctrl = this.f(name);
    if (!ctrl.invalid || !ctrl.touched) return null;
    if (ctrl.errors?.['required']) return 'Ce champ est obligatoire.';
    if (ctrl.errors?.['email'])    return 'Email invalide.';
    if (ctrl.errors?.['minlength']) return 'Minimum 8 caractères.';
    if (ctrl.errors?.['nonCorrespondant']) return 'Les mots de passe ne correspondent pas.';
    const srv = this.erreurs()[name];
    return srv ? srv[0] : null;
  }

  soumettre(): void {
    if (this.form.invalid) { this.form.markAllAsTouched(); return; }
    this.chargement.set(true);
    this.erreurs.set({});

    this.auth.inscrireClient(this.form.value as any).subscribe({
      next: () => this.auth.redirigerSelonRole(),
      error: (err) => {
        this.chargement.set(false);
        this.erreurs.set(err.error?.errors ?? {});
      },
    });
  }
}
