import { Component } from '@angular/core';
@Component({ selector: 'app-messagerie', standalone: true, template: `
  <div style="padding:24px 32px;">
    <div style="display:flex;justify-content:space-between;align-items:center;">
      <h1 style="font-size:1.6rem;font-weight:700;">MA MESSAGERIE</h1>
      <span>🔔 👤</span>
    </div>
    <hr style="border-color:#C9A84C;margin:12px 0 40px;"/>
    <div style="display:flex;flex-direction:column;align-items:center;justify-content:center;gap:16px;min-height:50vh;text-align:center;color:#666;">
      <div style="font-size:4rem;">💬</div>
      <h2 style="color:#C9A84C;">Messagerie</h2>
      <p>Bientôt disponible — discutez directement avec votre tailleur autour de chaque commande.</p>
    </div>
  </div>
` })
export class MessagerieComponent {}
