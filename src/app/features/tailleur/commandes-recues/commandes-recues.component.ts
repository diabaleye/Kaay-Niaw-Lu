import { Component, inject, signal, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { DashboardService } from '../../../core/services/dashboard.service';

@Component({
  selector: 'app-commandes-recues',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './commandes-recues.component.html',
})
export class CommandesRecuesComponent implements OnInit {
  private svc = inject(DashboardService);
  commandes  = signal<any[]>([]);
  filtreActif = signal('');
  chargement = signal(true);

  filtres = [
    { label: 'En attente de confection', valeur: 'en_attente' },
    { label: 'A confectionner',          valeur: 'a_confectionner' },
    { label: 'En cours de couture',      valeur: 'en_cours' },
    { label: 'Pret / En livraison',      valeur: 'pret' },
  ];

  ngOnInit() { this.charger(); }

  charger(statut?: string) {
    this.filtreActif.set(statut ?? '');
    this.chargement.set(true);
    this.svc.getCommandesTailleur(statut).subscribe({
      next: (d: any) => { this.commandes.set(d.commandes); this.chargement.set(false); },
      error: () => this.chargement.set(false),
    });
  }

  avancer(cmd: any) {
    const suivant: Record<string, string> = {
      'en_attente': 'a_confectionner', 'a_confectionner': 'en_cours',
      'en_cours': 'pret', 'pret': 'livre',
    };
    const prochain = suivant[cmd.statut];
    if (!prochain) return;
    this.svc.changerStatutCommande(cmd.id, prochain).subscribe({
      next: () => this.charger(this.filtreActif()),
    });
  }
}
