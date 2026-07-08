import { Component } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { SidebarTailorComponent } from '../../../components/sidebar-tailor/sidebar-tailor.component';
import { DashboardHeaderComponent } from '../../../components/dashboard-header/dashboard-header.component';

@Component({
  selector: 'app-messagerie',
  imports: [SidebarTailorComponent, DashboardHeaderComponent, FormsModule],
  templateUrl: './messagerie.component.html',
  styleUrl: './messagerie.component.css'
})
export class MessagerieComponent {
  newMessage = '';
  conversations = [
    { id: 1, name: 'Fanta Wane', lastMessage: 'Je le veux en couleur...' }
  ];
  activeConv = this.conversations[0];
  messages = [
    { id: 1, text: 'Salam Tidiane, ñiaw bi la done khol ndakh paré na?', outgoing: false },
    { id: 2, text: 'Waw Soxna Fanta, no déf? Paré na kay bane heure lagn la kay livré?', outgoing: true },
    { id: 3, text: 'Ah bon paré na kone! Machallah', outgoing: false },
    { id: 4, text: 'Waw bakhna si kanam inchallah', outgoing: true },
    { id: 5, text: 'Mane actuellement da ma liguéyi ni Sou ma ñibé da na la def signe inchallah', outgoing: false }
  ];

  sendMessage(): void {
    if (!this.newMessage.trim()) return;
    this.messages.push({ id: Date.now(), text: this.newMessage, outgoing: true });
    this.newMessage = '';
  }
}
