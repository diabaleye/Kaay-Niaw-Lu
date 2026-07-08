import { Component } from '@angular/core';
import { SidebarTailorComponent } from '../../../components/sidebar-tailor/sidebar-tailor.component';
import { DashboardHeaderComponent } from '../../../components/dashboard-header/dashboard-header.component';

@Component({
  selector: 'app-parametres',
  imports: [SidebarTailorComponent, DashboardHeaderComponent],
  templateUrl: './parametres.component.html',
  styleUrl: './parametres.component.css'
})
export class ParametresComponent {}
