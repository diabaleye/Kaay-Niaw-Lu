import { Component } from '@angular/core';
import { SidebarTailorComponent } from '../../../components/sidebar-tailor/sidebar-tailor.component';
import { DashboardHeaderComponent } from '../../../components/dashboard-header/dashboard-header.component';

@Component({
  selector: 'app-calendrier',
  imports: [SidebarTailorComponent, DashboardHeaderComponent],
  templateUrl: './calendrier.component.html',
  styleUrl: './calendrier.component.css'
})
export class CalendrierComponent {
  calendarDays = Array.from({ length: 30 }, (_, i) => ({
    date: i + 1,
    deliveries: [3, 7, 15, 22].includes(i + 1) ? 1 : 0
  }));
}
