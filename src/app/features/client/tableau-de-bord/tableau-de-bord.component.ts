import { Component, inject, signal, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { DashboardService } from '../../../core/services/dashboard.service';

@Component({
  selector: 'app-tableau-de-bord-client',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './tableau-de-bord.component.html',
})
export class TableauDeBordClientComponent implements OnInit {
  private svc = inject(DashboardService);
  bienvenue  = signal('');
  kpis       = signal<any>(null);
  chargement = signal(true);

  ngOnInit() {
    this.svc.getClientDashboard().subscribe({
      next: (d: any) => {
        this.bienvenue.set(d.bienvenue);
        this.kpis.set(d.kpis);
        this.chargement.set(false);
      },
      error: () => this.chargement.set(false),
    });
  }
}
