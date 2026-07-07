import { Component, OnInit } from '@angular/core';
import { SidebarTailorComponent } from '../../../components/sidebar-tailor/sidebar-tailor.component';
import { DashboardHeaderComponent } from '../../../components/dashboard-header/dashboard-header.component';
import { AuthService } from '../../../services/auth.service';
import { ApiService } from '../../../services/api.service';

@Component({
  selector: 'app-tableau-de-bord',
  imports: [SidebarTailorComponent, DashboardHeaderComponent],
  templateUrl: './tableau-de-bord.component.html',
  styleUrl: './tableau-de-bord.component.css'
})
export class TableauDeBordComponent implements OnInit {
  userName = 'TIDIANE';
  kpis = { enCours: 5, livrees: 7, ca: '350K' };
  capacity = 90;

  constructor(private auth: AuthService, private api: ApiService) {}

  ngOnInit(): void {
    const user = this.auth.getUser();
    if (user?.name) this.userName = user.name.toUpperCase();
    this.api.getTailorDashboard().subscribe({
      next: (data) => {
        if (data.kpis) this.kpis = data.kpis;
        if (data.capacity) this.capacity = data.capacity;
      },
      error: () => {}
    });
  }
}
