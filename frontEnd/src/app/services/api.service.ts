import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

const API = 'http://localhost:8000/api';

@Injectable({ providedIn: 'root' })
export class ApiService {
  constructor(private http: HttpClient) {}

  getArtisans(): Observable<any[]> {
    return this.http.get<any[]>(`${API}/artisans`);
  }

  sendContact(data: object): Observable<any> {
    return this.http.post(`${API}/contact`, data);
  }

  getTailorDashboard(): Observable<any> {
    return this.http.get(`${API}/tailor/dashboard`);
  }

  getClientDashboard(): Observable<any> {
    return this.http.get(`${API}/client/dashboard`);
  }

  getOrders(role: string): Observable<any[]> {
    return this.http.get<any[]>(`${API}/${role}/orders`);
  }

  getMeasurements(): Observable<any> {
    return this.http.get(`${API}/client/measurements`);
  }

  saveMeasurements(data: object): Observable<any> {
    return this.http.put(`${API}/client/measurements`, data);
  }

  getModeles(): Observable<any[]> {
    return this.http.get<any[]>(`${API}/tailor/modeles`);
  }

  getMessages(): Observable<any> {
    return this.http.get(`${API}/messages`);
  }
}
