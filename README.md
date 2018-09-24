# Country Module - ZF3 & Doctrine 2

Contains base entities for usage with countries. Entities included are:

 - Country ([ISO 3166-1](https://www.iso.org/obp/ui/#search))
    - Alpha2 codes (ISO 3166-1 alpha-2)
    - Alpha3 codes (ISO 3166-1 alpha-3)
    - Numeric codes (ISO 3166-1 numeric)
    - Country names (ISO 3166-1 (English))
 - Currency ([ISO 4217](https://www.currency-iso.org/en/home/tables/table-a1.html) ([XML](https://www.currency-iso.org/dam/downloads/lists/list_one.xml), [XLS](https://www.currency-iso.org/dam/downloads/lists/list_one.xls)))
    - Code (ISO 4217 alpha-3)
    - Numeric codes (ISO 4217 numeric)
    - Amount of decimals
    - Name (ISO 4217 full name (English))
 - Coordinates - Provided by [Google Maps](https://maps.google.com/) service (in URL's)
    - Latitude
    - Longitude
 - Languages
    - (Can't remember where I got these, sorry. Some ISO standard though)
 - Timezones
    - Generated on the fly when loading Fixtures - Provided by your locally installed PHP installation
    
Also contains useful items for using throughout modules/applications

 - Forms, Fieldsets & InputFilters for:
   - Country
   - Coordinates
   - Currency
   - Language
   - Timezone   
 
### TODO List

 - Add Continent entity
   - Use Continent as option groups for Country selectors
   - Allow Continent entities to be en-/disabled. With that, en-/disable related Country entities (batch update)
   - If a Country of a disabled Continent gets enabled, the Continent must also get enabled, but not enable all Country entities
   
### Contributing

Not quite yet sure how to set this up. But if you feel like contributing, throw an issue 
at the [repository](https://github.com/rkeet/zf-doctrine-country). 
 