import { Component, OnInit } from '@angular/core';
import { DecimalPipe } from '@angular/common';
import { SidebarTailorComponent } from '../../../components/sidebar-tailor/sidebar-tailor.component';
import { DashboardHeaderComponent } from '../../../components/dashboard-header/dashboard-header.component';
import { ApiService } from '../../../services/api.service';

@Component({
  selector: 'app-atelier',
  imports: [SidebarTailorComponent, DashboardHeaderComponent, DecimalPipe],
  templateUrl: './atelier.component.html',
  styleUrl: './atelier.component.css'
})
export class AtelierComponent implements OnInit {
  activeTab = 'Tous les modèles';
  tabs = ['Tous les modèles', 'Grands boubous', 'Kaftans et robes', 'Tuniques modernes'];
  modeles = [
    { id: 1, name: 'Sabador SAMBA', fabric: 'Bazin Riche', price: 50000 },
    { id: 2, name: 'Sabador SAMBA', fabric: 'Bazin Riche', price: 50000 },
    { id: 3, name: 'Sabador SAMBA', fabric: 'Bazin Riche', price: 50000 }
  ];

  constructor(private api: ApiService) {}

  ngOnInit(): void {
    this.api.getModeles().subscribe({
      next: (data) => { if (data?.length) this.modeles = data; },
      error: () => {}
    });
  }
}
