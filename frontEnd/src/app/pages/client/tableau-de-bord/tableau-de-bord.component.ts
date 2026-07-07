import { Component, OnInit } from '@angular/core';
import { SidebarClientComponent } from '../../../components/sidebar-client/sidebar-client.component';
import { DashboardHeaderComponent } from '../../../components/dashboard-header/dashboard-header.component';
import { AuthService } from '../../../services/auth.service';
import { ApiService } from '../../../services/api.service';

@Component({
  selector: 'app-tableau-de-bord',
  imports: [SidebarClientComponent, DashboardHeaderComponent],
  templateUrl: './tableau-de-bord.component.html',
  styleUrl: './tableau-de-bord.component.css'
})
export class TableauDeBordComponent implements OnInit {
  userName = 'FANTA';
  kpis = { enCours: 5, livrees: 7, notifications: 3 };

  constructor(private auth: AuthService, private api: ApiService) {}

  ngOnInit(): void {
    const user = this.auth.getUser();
    if (user?.name) this.userName = user.name.toUpperCase();
    this.api.getClientDashboard().subscribe({
      next: (data) => { if (data.kpis) this.kpis = data.kpis; },
      error: () => {}
    });
  }
}
