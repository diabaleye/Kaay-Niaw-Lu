import { Component, OnInit } from '@angular/core';
import { SidebarTailorComponent } from '../../../components/sidebar-tailor/sidebar-tailor.component';
import { DashboardHeaderComponent } from '../../../components/dashboard-header/dashboard-header.component';
import { ApiService } from '../../../services/api.service';

@Component({
  selector: 'app-commandes',
  imports: [SidebarTailorComponent, DashboardHeaderComponent],
  templateUrl: './commandes.component.html',
  styleUrl: './commandes.component.css'
})
export class CommandesComponent implements OnInit {
  activeTab = 'En attente de confection';
  tabs = ['En attente de confection', 'A confectionner', 'En cours de couture', 'Prêt / En livraison'];
  orders = [
    { id: 1, reference: '#CMD-2026-0042', client_name: 'Fatou SARR', fabric_type: 'Bazin Riche', progress: 85 }
  ];

  constructor(private api: ApiService) {}

  ngOnInit(): void {
    this.api.getOrders('tailor').subscribe({
      next: (data) => { if (data?.length) this.orders = data; },
      error: () => {}
    });
  }
}
