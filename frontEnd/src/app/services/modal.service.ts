import { Injectable } from '@angular/core';
import { Subject } from 'rxjs';

export interface ModalConfig {
  title: string;
  message?: string;
  type?: 'info' | 'success' | 'error' | 'confirm' | 'form';
  confirmLabel?: string;
  cancelLabel?: string;
  fields?: ModalField[];
}

export interface ModalField {
  name: string;
  label: string;
  type?: 'text' | 'email' | 'password' | 'number' | 'select' | 'textarea';
  value?: string | number;
  options?: { value: string; label: string }[];
  required?: boolean;
}

export interface ModalResult {
  confirmed: boolean;
  values?: Record<string, string | number>;
}

@Injectable({ providedIn: 'root' })
export class ModalService {
  private modalState = new Subject<{ config: ModalConfig; resolve: (r: ModalResult) => void } | null>();
  state$ = this.modalState.asObservable();

  open(config: ModalConfig): Promise<ModalResult> {
    return new Promise((resolve) => {
      this.modalState.next({ config, resolve });
    });
  }

  close(result: ModalResult): void {
    const current = this.modalState;
    this.modalState.next(null);
    return result as unknown as void;
  }

  alert(title: string, message: string, type: 'info' | 'success' | 'error' = 'info'): Promise<void> {
    return this.open({ title, message, type, confirmLabel: 'OK' }).then(() => undefined);
  }

  confirm(title: string, message: string): Promise<boolean> {
    return this.open({
      title,
      message,
      type: 'confirm',
      confirmLabel: 'Confirmer',
      cancelLabel: 'Annuler'
    }).then(r => r.confirmed);
  }

  form(title: string, fields: ModalField[]): Promise<ModalResult> {
    return this.open({ title, type: 'form', fields, confirmLabel: 'Enregistrer', cancelLabel: 'Annuler' });
  }
}
