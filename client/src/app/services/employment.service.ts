/**
 * Created by Bugatti on 29/07/2017.
 */
import { Injectable } from '@angular/core';
import { Employment } from '../class/employment'
import { Http } from "@angular/http";
import 'rxjs/add/operator/toPromise';
import { BaseService } from "./base.service";
import { OAuthService } from "angular-oauth2-oidc";

@Injectable()
export class EmploymentService extends BaseService{
    constructor(private http: Http, oauthService: OAuthService){
        super(oauthService);
    }

    // parent function based on class name don't work after npm build so override it until abstract solution is found
    getEntityName(){
        return 'employment';
    }

    getEmployment(id: number): Promise<Employment> {
        return this.http.get(this.getEntityUrl()+"/"+id+".json", {headers: this.headers})
            .toPromise()
            .then(response => response.json())
            .catch(this.handleError);
    }

    getEntrepriseEmployment(entreprise_id: number): Promise<Employment[]> {
        return this.http.get(this.baseUrl + "entreprise" + "/" + entreprise_id + "/employments.json", {headers: this.headers})
            .toPromise()
            .then(response => response.json())
            .catch(this.handleError);
    }

    createEntrepriseEmployment(entreprise_id : number, employment: Employment): Promise<Employment> {
        return this.http
            .post(this.baseUrl + "entreprise" + "/" + entreprise_id + "/employment", this.serialize(employment), {headers: this.headers})
            .toPromise()
            .then(res => res.json())
            .catch(this.handleError);
    }

    update(employment: Employment): Promise<Employment>{
        const url = `${this.getEntityUrl()}/${employment.id}`;
        return this.http
            .put(url, this.serialize(employment), {headers: this.headers})
            .toPromise()
            .then(() => employment)
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