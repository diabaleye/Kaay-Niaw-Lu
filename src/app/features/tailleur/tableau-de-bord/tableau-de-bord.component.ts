import { Component, inject, signal, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterLink } from '@angular/router';
import { DashboardService } from '../../../core/services/dashboard.service';

@Component({
  selector: 'app-tableau-de-bord-tailleur',
  standalone: true,
  imports: [CommonModule, RouterLink],
  templateUrl: './tableau-de-bord.component.html',
})
export class TableauDeBordTailleurComponent implements OnInit {
  private svc = inject(DashboardService);
  data       = signal<any>(null);
  chargement = signal(true);

  ngOnInit() {
    this.svc.getTailleurDashboard().subscribe({
      next: (d: any) => { this.data.set(d); this.chargement.set(false); },
      error: () => this.chargement.set(false),
    });
  }
}
