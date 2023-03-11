import {autoinject, inject, LogManager, NewInstance} from 'aurelia-framework';
import { Logger } from 'aurelia-logging';
import {HttpClient, HttpClientConfiguration, json} from "aurelia-fetch-client";
import {Pokemon} from "../models/Pokemon";
import {serialize} from "v8";

@inject(NewInstance.of(HttpClient))
export class PokemonService {
    private logger:Logger = LogManager.getLogger('PokemonService');
    public constructor(
        private httpClient: HttpClient
    )
    {
        this.httpClient.configure((config:HttpClientConfiguration)  => {
            config
                .withDefaults({
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Content-Type' : 'application/json',
                        'Accept': 'application/json'
                    },
                    credentials:'include'
                });
        });
    }

    public getPokemons(): any
    {
        return this.httpClient
            .get('/api/pokemons')
            .then((response) => {
                if (response.status === 200) {
                    return response.json()
                }
                throw new Error('Unauthorized');
            })
            .then((data) => {
                return data;
            });
    }

    public getTypes(): any
    {
        return this.httpClient
            .get('/api/types')
            .then((response) => {
                if (response.status === 200) {
                    return response.json()
                }
                throw new Error('Unauthorized');
            })
            .then((data) => {
                return data;
            });
    }

    public searchPokemon(body){
        return this.httpClient
            .post('/api/search/pokemon', JSON.stringify(body))
            .then((response) => {
                if (response.status === 200) {
                    return response.json()
                }
                throw new Error('Unauthorized');
            })
            .then((data) => {
                return data;
            });
    }
}