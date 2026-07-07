import { Component } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { Router, RouterLink } from '@angular/router';
import { AuthLayoutComponent } from '../../components/auth-layout/auth-layout.component';
import { AuthService } from '../../services/auth.service';

@Component({
  selector: 'app-inscription-client',
  imports: [AuthLayoutComponent, FormsModule, RouterLink],
  templateUrl: './inscription-client.component.html',
  styleUrl: './inscription-client.component.css'
})
export class InscriptionClientComponent {
  form = {
    prenom: '', nom: '', email: '', pseudo: '', telephone: '',
    password: '', password_confirmation: '', role: 'client'
  };

  constructor(private auth: AuthService, private router: Router) {}

  onRegister(): void {
    this.auth.register(this.form).subscribe({
      next: () => this.router.navigate(['/connexion']),
      error: () => this.router.navigate(['/connexion'])
    });
  }
}
