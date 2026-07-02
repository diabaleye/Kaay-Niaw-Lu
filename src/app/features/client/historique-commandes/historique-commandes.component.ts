import { Component, inject, signal, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { DashboardService } from '../../../core/services/dashboard.service';

@Component({
  selector: 'app-historique-commandes',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './historique-commandes.component.html',
})
export class HistoriqueCommandesComponent implements OnInit {
  private svc = inject(DashboardService);
  commandes  = signal<any[]>([]);
  chargement = signal(true);

  ngOnInit() {
    this.svc.getCommandesClient().subscribe({
      next: (d: any) => { this.commandes.set(d.commandes); this.chargement.set(false); },
      error: () => this.chargement.set(false),
    });
  }

  statutLabel(statut: string): string {
    const map: Record<string, string> = {
      'en_attente': 'EN ATTENTE', 'a_confectionner': 'A CONFECTIONNER',
      'en_cours': 'EN COURS', 'pret': 'PRET', 'livre': 'LIVREE', 'annule': 'ANNULEE',
    };
    return map[statut] ?? statut.toUpperCase();
  }

  statutCouleur(statut: string): string {
    return statut === 'livre' ? '#16a34a' : statut === 'annule' ? '#dc2626' : '#C9A84C';
  }
}
