import { Component } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { Router, RouterLink } from '@angular/router';
import { LogoComponent } from '../../components/logo/logo.component';

@Component({
  selector: 'app-inscription-role',
  imports: [LogoComponent, FormsModule, RouterLink],
  templateUrl: './inscription-role.component.html',
  styleUrl: './inscription-role.component.css'
})
export class InscriptionRoleComponent {
  selectedRole = 'client';

  constructor(private router: Router) {}

  continue(): void {
    this.router.navigate([this.selectedRole === 'tailleur' ? '/inscription/tailleur' : '/inscription/client']);
  }
}
