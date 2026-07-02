import { Component, signal } from '@angular/core';
import { CommonModule } from '@angular/common';
@Component({
  selector: 'app-parametres', standalone: true, imports: [CommonModule],
  templateUrl: './parametres.component.html',
})
export class ParametresComponent {
  confirmer = signal(false);
}
