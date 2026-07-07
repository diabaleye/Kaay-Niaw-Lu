import { Component } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { SidebarClientComponent } from '../../../components/sidebar-client/sidebar-client.component';
import { DashboardHeaderComponent } from '../../../components/dashboard-header/dashboard-header.component';

@Component({
  selector: 'app-messagerie',
  imports: [SidebarClientComponent, DashboardHeaderComponent, FormsModule],
  templateUrl: './messagerie.component.html',
  styleUrl: './messagerie.component.css'
})
export class MessagerieComponent {
  newMessage = '';
  conversations = [{ id: 1, name: 'Fanta Wane', lastMessage: 'Je le veux en couleur...' }];
  activeConv = this.conversations[0];
  messages = [
    { id: 1, text: 'Waw Soxna Fanta, no déf? Paré na kay bane heure lagn la kay livré?', outgoing: false },
    { id: 2, text: 'Salam Tidiane, ñiaw bi la done khol ndakh paré na?', outgoing: true },
    { id: 3, text: 'Waw bakhna si kanam inchallah', outgoing: false },
    { id: 4, text: 'Ah bon paré na kone! Machallah', outgoing: true },
    { id: 5, text: 'Mane actuellement da ma liguéyi ni Sou ma ñibé da na la def signe inchallah', outgoing: true }
  ];

  sendMessage(): void {
    if (!this.newMessage.trim()) return;
    this.messages.push({ id: Date.now(), text: this.newMessage, outgoing: true });
    this.newMessage = '';
  }
}
