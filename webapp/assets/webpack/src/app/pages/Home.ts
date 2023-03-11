import { Logger } from 'aurelia-logging';
import {autoinject, LogManager} from 'aurelia-framework';
import {Router} from "aurelia-router";
import {EventAggregator} from "aurelia-event-aggregator";
import {PokemonService} from "../services/PokemonService";
import {Pokemon, Type} from "../models/Pokemon";
@autoinject()
export class Home
{
    private logger:Logger = LogManager.getLogger('HomePage');
    public pokemons:Pokemon[];
    public types:Type[];
    public coverages:any = [];
    public pokemon1Id:any;
    public pokemon2Id:any;
    public pokemon3Id:any;
    public pokemon4Id:any;
    public pokemon5Id:any;
    public pokemon6Id:any;
    public pokemon1:any;
    public pokemon2:any;
    public pokemon3:any;
    public pokemon4:any;
    public pokemon5:any;
    public pokemon6:any;

    public search;
    public type1;
    public type2;
    public pokemonSearch;

    public interviewNumber = 0;
    public year = new Date().getFullYear();
    public text;
    public constructor(
        private pokemonService:PokemonService
    )
    {
        this.logger.debug('Construct');
    }

    public attached()
    {
        let pkms:any = sessionStorage.getItem('pokemons');
        if (pkms !== null) {
            this.pokemons = JSON.parse(pkms);
        } else {
            this.pokemonService.getPokemons()
                .then((pokemons) => {
                    this.pokemons = pokemons;
                    sessionStorage.setItem('pokemons', JSON.stringify(pokemons));
                });
        }
        this.pokemonService.getTypes()
            .then((types) => {
                this.types = types;
                for (let i in types) {
                    this.coverages.push({
                       'type' : types[i].nameFr,
                       'pokemonCoverage1' : {'value' : '-', 'style' : ''},
                       'pokemonCoverage2' : {'value' : '-', 'style' : ''},
                       'pokemonCoverage3' : {'value' : '-', 'style' : ''},
                       'pokemonCoverage4' : {'value' : '-', 'style' : ''},
                       'pokemonCoverage5' : {'value' : '-', 'style' : ''},
                       'pokemonCoverage6' : {'value' : '-', 'style' : ''},
                       'totalWeak' : 0,
                       'totalResist' : 0,
                    });
                }
                console.log(this.coverages);
            });
    }

    public changePokemon(number) {
        switch (number) {
            case 1:
                this.pokemon1 = new Pokemon(this.pokemons.find(pokemon => pokemon.id == this.pokemon1Id));
                this.computeCoverage(1, this.pokemon1);
                break;
            case 2:
                this.pokemon2 = new Pokemon(this.pokemons.find(pokemon => pokemon.id == this.pokemon2Id));
                this.computeCoverage(2, this.pokemon2);
                break;
            case 3:
                this.pokemon3 = new Pokemon(this.pokemons.find(pokemon => pokemon.id == this.pokemon3Id));
                this.computeCoverage(3, this.pokemon3);
                break;
            case 4:
                this.pokemon4 = new Pokemon(this.pokemons.find(pokemon => pokemon.id == this.pokemon4Id));
                this.computeCoverage(4, this.pokemon4);
                break;
            case 5:
                this.pokemon5 = new Pokemon(this.pokemons.find(pokemon => pokemon.id == this.pokemon5Id));
                this.computeCoverage(5, this.pokemon5);
                break;
            case 6:
                this.pokemon6 = new Pokemon(this.pokemons.find(pokemon => pokemon.id == this.pokemon6Id));
                this.computeCoverage(6, this.pokemon6);
                break;
        }
    }

    public computeCoverage(position:number, pokemon:Pokemon) {
        for (let j in this.coverages) {
            this.coverages[j]['pokemonCoverage'+position]['value'] = '-';
            this.coverages[j]['pokemonCoverage'+position]['style'] = '';
        }
        let pokemonTypes:Type[] = [];
        if (pokemon.id) {
            pokemonTypes.push(pokemon.type1);
            if (pokemon.type2) {
                pokemonTypes.push(pokemon.type2);
            }
        }

        for (let i in pokemonTypes) {
            for (let j in pokemonTypes[i].coverages) {
                let typeName:any = this.types.find(type => type.id == pokemonTypes[i].coverages[j].targetTypeId);
                this.coverageValue(typeName.nameFr, position, pokemonTypes[i].coverages[j].status);
            }
        }
        this.computeTotals();
    }

    public coverageValue(type, position, wor) {
        const index = this.coverages.findIndex((coverage) => coverage.type === type);
        if (wor == 'immune') {
            this.coverages[index]['pokemonCoverage' + position]['value'] = 'immune';
        } else {
            switch (this.coverages[index]['pokemonCoverage'+position]['value']) {
                case '1/2':
                    this.coverages[index]['pokemonCoverage'+position]['value'] = wor == 'weak' ? '-' : '1/4';
                    break;
                case '-':
                    this.coverages[index]['pokemonCoverage'+position]['value'] = wor == 'weak' ? '2x' : '1/2';
                    break;
                case '2x':
                    this.coverages[index]['pokemonCoverage'+position]['value'] = wor == 'weak' ? '4x' : '-';
                    break;
            }
        }
    }

    public computeTotals() {
       for (let i in this.coverages) {
           let totalWeak = 0;
           let totalResist = 0;
           let coverages = [
               this.coverages[i]['pokemonCoverage1']['value'],
               this.coverages[i]['pokemonCoverage2']['value'],
               this.coverages[i]['pokemonCoverage3']['value'],
               this.coverages[i]['pokemonCoverage4']['value'],
               this.coverages[i]['pokemonCoverage5']['value'],
               this.coverages[i]['pokemonCoverage6']['value'],
           ];
           for (let j in coverages) {
               let count = parseInt(j)+1;
               switch (coverages[j]) {
                   case '1/2':
                       this.coverages[i]['pokemonCoverage'+count]['style'] = 'background-color: #b9ffbd';
                       totalResist++;
                       break;
                   case '1/4':
                       this.coverages[i]['pokemonCoverage'+count]['style'] = 'background-color: #6ad370';
                       totalResist++;
                       break;
                   case 'immune':
                       this.coverages[i]['pokemonCoverage'+count]['style'] = 'background-color: #c7c7c7';
                       totalResist++;
                       break;
                   case '2x':
                       this.coverages[i]['pokemonCoverage'+count]['style'] = 'background-color: #ffc4c4';
                       totalWeak++;
                       break;
                   case '4x':
                       this.coverages[i]['pokemonCoverage'+count]['style'] = 'background-color: #df7e7e';
                       totalWeak++;
                       break;
               }
           }
           this.coverages[i]['totalWeak'] = totalWeak;
           this.coverages[i]['totalResist'] = totalResist;
       }
    }

    public submitSearch() {
        let body = {
            search : this.search,
            type1Id : this.type1,
            type2Id : this.type2
        };

        this.pokemonService.searchPokemon(body)
            .then((pokemons) => {
                this.pokemonSearch = pokemons;
            });
    }
}