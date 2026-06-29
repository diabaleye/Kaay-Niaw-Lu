import { ComponentFixture, TestBed } from '@angular/core/testing';

import { CalendrierLivraisons } from './calendrier-livraisons';

describe('CalendrierLivraisons', () => {
  let component: CalendrierLivraisons;
  let fixture: ComponentFixture<CalendrierLivraisons>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [CalendrierLivraisons],
    }).compileComponents();

    fixture = TestBed.createComponent(CalendrierLivraisons);
    component = fixture.componentInstance;
    await fixture.whenStable();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
