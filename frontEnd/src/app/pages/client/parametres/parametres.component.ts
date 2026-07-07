import { Component } from '@angular/core';
import { SidebarClientComponent } from '../../../components/sidebar-client/sidebar-client.component';
import { DashboardHeaderComponent } from '../../../components/dashboard-header/dashboard-header.component';

@Component({
  selector: 'app-parametres',
  imports: [SidebarClientComponent, DashboardHeaderComponent],
  templateUrl: './parametres.component.html',
  styleUrl: './parametres.component.css'
})
export class ParametresComponent {}
