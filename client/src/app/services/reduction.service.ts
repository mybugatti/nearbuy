/**
 * Created by Bugatti on 29/07/2017.
 */
import { Injectable } from '@angular/core';
import { Reduction } from '../class/reduction'
import { Http } from "@angular/http";
import 'rxjs/add/operator/toPromise';
import { BaseService } from "./base.service";
import { OAuthService } from "angular-oauth2-oidc";

@Injectable()
export class ReductionService extends BaseService{
    constructor(private http: Http, oauthService: OAuthService){
        super(oauthService);
    }

    // parent function based on class name don't work after npm build so override it until abstract solution is found
    getEntityName(){
        return 'reduction';
    }

    getReductions(): Promise<Reduction[]>{
        return this.http.get(this.getEntityUrl()+"s", {headers: this.headers})
            .toPromise()
            .then(response => response.json())
            .catch(this.handleError);
    }

    getReduction(id: number): Promise<Reduction> {
        return this.http.get(this.getEntityUrl()+"/"+id+".json", {headers: this.headers})
            .toPromise()
            .then(response => response.json())
            .catch(this.handleError);
    }

    create(reduction : Reduction): Promise<Reduction> {
        return this.http
            .post(this.getEntityUrl(), this.serialize(reduction), {headers: this.headers})
            .toPromise()
            .then(res => res.json())
            .catch(this.handleError);
    }

    update(reduction: Reduction): Promise<Reduction>{
        const url = `${this.getEntityUrl()}/${reduction.id}`;
        return this.http
            .put(url, this.serialize(reduction), {headers: this.headers})
            .toPromise()
            .then(() => reduction)
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