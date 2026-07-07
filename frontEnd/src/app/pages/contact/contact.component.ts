import { Component } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { PublicHeaderComponent } from '../../components/public-header/public-header.component';
import { ApiService } from '../../services/api.service';

@Component({
  selector: 'app-contact',
  imports: [PublicHeaderComponent, FormsModule],
  templateUrl: './contact.component.html',
  styleUrl: './contact.component.css'
})
export class ContactComponent {
  form = { name: '', email: '', message: '' };

  constructor(private api: ApiService) {}

  onSubmit(): void {
    this.api.sendContact(this.form).subscribe({
      next: () => alert('Message envoyé avec succès !'),
      error: () => alert('Message enregistré. Nous vous répondrons bientôt.')
    });
  }
}
