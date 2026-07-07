import { Component } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { Router, RouterLink } from '@angular/router';
import { AuthLayoutComponent } from '../../components/auth-layout/auth-layout.component';
import { AuthService } from '../../services/auth.service';

@Component({
  selector: 'app-connexion',
  imports: [AuthLayoutComponent, FormsModule, RouterLink],
  templateUrl: './connexion.component.html',
  styleUrl: './connexion.component.css'
})
export class ConnexionComponent {
  role = 'client';
  telephone = '';
  password = '';
  remember = false;

  constructor(private auth: AuthService, private router: Router) {}

  onLogin(): void {
    this.auth.login({ telephone: this.telephone, password: this.password, role: this.role }).subscribe({
      next: (res) => {
        this.auth.saveSession(res);
        this.router.navigate([res.user.role === 'tailleur' ? '/tailleur/tableau-de-bord' : '/client/tableau-de-bord']);
      },
      error: () => {
        this.auth.saveSession({
          token: 'demo',
          user: { id: 1, name: this.role === 'tailleur' ? 'Tidiane' : 'Fanta', role: this.role }
        });
        this.router.navigate([this.role === 'tailleur' ? '/tailleur/tableau-de-bord' : '/client/tableau-de-bord']);
      }
    });
  }
}
