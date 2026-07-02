import { Component, signal } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterLink } from '@angular/router';
@Component({
  selector: 'app-contact', standalone: true,
  imports: [CommonModule, RouterLink],
  templateUrl: './contact.component.html',
})
export class ContactComponent {
  envoye = signal(false);
  envoyer() { this.envoye.set(true); }
}
