import { Component, OnDestroy, OnInit } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { Subscription } from 'rxjs';
import { ModalConfig, ModalField, ModalResult, ModalService } from '../../services/modal.service';

@Component({
  selector: 'app-modal',
  imports: [FormsModule],
  templateUrl: './modal.component.html',
  styleUrl: './modal.component.css'
})
export class ModalComponent implements OnInit, OnDestroy {
  visible = false;
  config: ModalConfig | null = null;
  formValues: Record<string, string | number> = {};
  private resolve?: (r: ModalResult) => void;
  private sub?: Subscription;

  constructor(private modal: ModalService) {}

  ngOnInit(): void {
    this.sub = this.modal.state$.subscribe(state => {
      if (!state) {
        this.visible = false;
        this.config = null;
        return;
      }
      this.config = state.config;
      this.resolve = state.resolve;
      this.formValues = {};
      state.config.fields?.forEach((f: ModalField) => {
        this.formValues[f.name] = f.value ?? '';
      });
      this.visible = true;
    });
  }

  ngOnDestroy(): void {
    this.sub?.unsubscribe();
  }

  onConfirm(): void {
    this.resolve?.({ confirmed: true, values: { ...this.formValues } });
    this.close();
  }

  onCancel(): void {
    this.resolve?.({ confirmed: false });
    this.close();
  }

  onBackdropClick(event: MouseEvent): void {
    if ((event.target as HTMLElement).classList.contains('modal-backdrop')) {
      this.onCancel();
    }
  }

  private close(): void {
    this.visible = false;
    this.config = null;
  }
}
