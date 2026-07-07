import { Component } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { Router, RouterLink } from '@angular/router';
import { AuthLayoutComponent } from '../../components/auth-layout/auth-layout.component';
import { AuthService } from '../../services/auth.service';

@Component({
  selector: 'app-inscription-tailleur',
  imports: [AuthLayoutComponent, FormsModule, RouterLink],
  templateUrl: './inscription-tailleur.component.html',
  styleUrl: './inscription-tailleur.component.css'
})
export class InscriptionTailleurComponent {
  form = {
    prenom: '', nom: '', email: '', pseudo: '', telephone: '',
    password: '', password_confirmation: '', role: 'tailleur',
    workshop_name: '', location: '', specialties: '',
    max_orders: '', avg_production_time: ''
  };

  constructor(private auth: AuthService, private router: Router) {}

  onRegister(): void {
    this.auth.register(this.form).subscribe({
      next: () => this.router.navigate(['/connexion']),
      error: () => this.router.navigate(['/connexion'])
    });
  }
}
