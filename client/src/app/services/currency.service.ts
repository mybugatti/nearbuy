/**
 * Created by Bugatti on 29/07/2017.
 */
import { Injectable } from '@angular/core';
import { Currency } from '../class/currency'
import { Http } from "@angular/http";
import 'rxjs/add/operator/toPromise';
import { BaseService } from "./base.service";
import { OAuthService } from "angular-oauth2-oidc";

@Injectable()
export class CurrencyService extends BaseService{
    constructor(private http: Http, oauthService: OAuthService){
        super(oauthService);
    }

    // parent function based on class name don't work after npm build so override it until abstract solution is found
    getEntityName(){
        return 'currency';
    }

    getCurrencies(): Promise<Currency[]>{
        return this.http.get(this.baseUrl + "currencies", {headers: this.headers})
            .toPromise()
            .then(response => response.json())
            .catch(this.handleError);
    }

    getCurrency(id: number): Promise<Currency> {
        return this.http.get(this.getEntityUrl()+"/"+id+".json", {headers: this.headers})
            .toPromise()
            .then(response => response.json())
            .catch(this.handleError);
    }

    create(currency: Currency): Promise<Currency> {
        return this.http
            .post(this.getEntityUrl(), this.serialize(currency), {headers: this.headers})
            .toPromise()
            .then(res => res.json())
            .catch(this.handleError);
    }

    update(currency: Currency): Promise<Currency>{
        const url = `${this.getEntityUrl()}/${currency.id}`;
        return this.http
            .put(url, this.serialize(currency), {headers: this.headers})
            .toPromise()
            .then(() => currency)
            .catch(this.handleError);
    }

    remove(id: number): Promise<void> {
        const url = `${this.getEntityUrl()}/${id}`;
        return this.http.delete(url, {headers: this.headers})
            .toPromise()
            .then(() => null)
            .catch(this.handleError);
    }
}