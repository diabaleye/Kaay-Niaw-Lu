import { Component, OnInit } from '@angular/core';
import { SidebarClientComponent } from '../../../components/sidebar-client/sidebar-client.component';
import { DashboardHeaderComponent } from '../../../components/dashboard-header/dashboard-header.component';
import { ApiService } from '../../../services/api.service';

@Component({
  selector: 'app-commandes',
  imports: [SidebarClientComponent, DashboardHeaderComponent],
  templateUrl: './commandes.component.html',
  styleUrl: './commandes.component.css'
})
export class CommandesComponent implements OnInit {
  orders = [
    { id: 1, reference: '#CMD-2026-0042', tailor_name: 'CHEIKH FALL', fabric_type: 'Bazin Riche', deadline: '30/06/2026', status: 'EN COURS' },
    { id: 2, reference: '#CMD-2026-0038', tailor_name: 'CHEIKH FALL', fabric_type: 'Bazin Riche', deadline: '15/05/2026', status: 'LIVREE' }
  ];

  constructor(private api: ApiService) {}

  ngOnInit(): void {
    this.api.getOrders('client').subscribe({
      next: (data) => { if (data?.length) this.orders = data; },
      error: () => {}
    });
  }
}
