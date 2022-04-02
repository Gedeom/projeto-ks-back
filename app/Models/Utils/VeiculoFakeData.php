<?php

namespace App\Models\Utils;

class VeiculoFakeData
{
    public static function getBrandsWithModels(): array
    {
        return static::$brandsWithModels;
    }

    public static function getBrands(): array
    {
//        $brands = static::$brandsWithModels
        return array_keys(static::$brandsWithModels);
    }

    public static function getModels(): array
    {
        $values = array_reduce(array_values(static::$brandsWithModels), function ($ant,$item) {
            return array_merge($ant,$item);
        },[]);

        return $values;
    }

    protected
    static $brandsWithModels = array(
        'Alfa Romeo' => array(
            '145', '146', '147', '155', '156', '164', '166', '33', '75', '90', 'Alfasud', 'Alfetta', 'Arna',
            'Giulietta', 'Gold Cloverleaf', 'GTV', 'Spider', 'Sprint', 'SZ', 'GT', 'Imola', '1333', 'Das', 'AR',
            'Giulia', 'GTA', '2600', 'Montreal', '159', 'Brera', '169', '149', 'Junior', 'Mito', 'Crosswagon',
            '6 (119)', '4C', 'Stelvio'
        ),
        'Alpine' => array(
            'A110', 'A310', 'A610'
        ),
        'Altamarea' => array(
            '2E'
        ),
        'Aro' => array(
            '10', '24', 'Spartana', '461', '104', '244', '243', '240', '245', '246'
        ),
        'Artega' => array(
            'GT'
        ),
        'Asia' => array(
            'Rocsta', 'Topic', 'Towner', 'Cosmos'
        ),
        'Aston Martin' => array(
            'DB7', 'Lagonda', 'V8', 'Vanquish', 'Vantage', 'Virage', 'Volante', 'V12', 'DB9', 'Bulldog', 'Tick',
            'Tickford Capri', 'Zagato', 'V8 Vantage', 'DBS', 'Rapide', 'Cygnet', 'DB11'
        ),
        'Audi' => array(
            '100', '200', '80', '90', 'A2', 'A3', 'A4', 'A6', 'A8', 'RS6', 'RS4', 'S3', 'S4', 'S6', 'S8', 'V8', 'TT',
            'Q7', 'A5', 'R8', 'S5', 'Q5', 'TTS', 'A4 Allroad', 'A6 Allroad', 'S2', 'A1', 'A7', 'RS5', 'DKW', 'TT RS',
            'TT (все)', 'RS3', 'Q3', 'S7 Sportback', 'SQ', '50', 'RS7', 'RS 4 Avant', 'RS Q3', 'SQ5', 'Q7 E-tron',
            'A3 Sportback E-tron', 'SQ7', 'Q2'
        ),
        'Austin' => array(
            'Allegro', 'Ambassador', 'Maestro', 'Maxi', 'Maxi 2', 'Metro', 'Mini', 'Mini Classic', 'Montego',
            'Princess', 'Mini MK', 'Montego Kombi', 'Princess 2', 'Rover', 'FX'
        ),
        'Austin-Healey' => array(
            '3000'
        ),
        'Autobianchi' => array(
            'A 112'
        ),
        'Barkas (Баркас)' => array(
            'B1000', '1001', 'VEB', '1990'
        ),
        'Beijing' => array(
            'BJ 2020', 'Land King', 'BJ 2021', 'BW4Y'
        ),
        'Bentley' => array(
            'Arnage', 'Azure', 'Brooklands', 'Continental', 'Corniche', 'Eight', 'Mulsanne', 'Series II', 'Turbo R',
            'Turbo RT', 'T 2', 'T 1', 'S 2', 'S 1', 'Mark VI', 'Speed 8', 'Continental Supersports', 'Flying Spur',
            'Bentayga', 'Flying Spur V8', 'Continental GT V8', 'Continental GT V8 S'
        ),
        'Bertone' => array(
            'Freeclimber'
        ),
        'Bio Auto' => array(
            'evA-5', 'evA-2', 'evA-4'
        ),
        'Blonell' => array(
            'TF 2000 MK1'
        ),
        'BMW' => array(
            '8 Series', 'M1', 'X5', 'Z1', 'Z3', 'Z4', 'Z8', 'Alpina', 'E', 'X3', 'M', 'X6', '1 Series', '5 Series',
            'X5 M', 'M5', '750', '6 Series', '3 Series', 'M3', 'X6 M', 'M6', 'X1', '7 Series', '325', '324', '316',
            '320', '318', '328', '523', '740', '520', '728', '525', 'Isetta', '530', '528', '545', '535', 'Dixi',
            '730', '745', '518', '524', '540', '116', '118', '120', '123', '125', '130', '135', '323', '330', '335',
            '550', '628', '630', '633', '635', '645', '650', '640', '760', '735', '732', '725', 'X series', 'X8',
            '340', 'RR', '1 Series М', '321', '315', '6 Series Gran Coupe', 'X2', '4 Series', '428', '435', '420',
            '2 Series', '3 Series GT', 'X4', '4 Series Gran Coupe', '326', 'I8', '5 Series GT', 'I3', 'M2', 'M4',
            'Neue Klasse', '1602', 'Active Hybrid 7', '2002', '2000', 'F10', 'X7', '128', '6 Series GT'
        ),
        'Bristol' => array(
            '412', '603', 'Beaufighter', 'Blenheim', 'Brigand', 'Britannia', 'Fighter', 'Speedster'
        ),
        'Bugatti' => array(
            'EB 110', 'EB 112', 'Veyron', 'Galibier', 'Chiron'
        ),
        'Buick' => array(
            'Century', 'GL 8', 'LaCrosse', 'LE Sabre', 'Park Avenue', 'Rainer', 'Reatta', 'Regal', 'Rendezvous',
            'Riviera', 'Enclave', 'LuCerne', 'Enclave USA', 'LaCrosse USA', 'Skylark', 'Wildcat', 'Roadmaster',
            'Special', 'Limitet', 'Encore', 'Super', 'Electra', 'Skyhawk', 'Regal GS', 'Cascada', 'Verano', 'Eight',
            'Envision'
        ),
        'Cadillac' => array(
            'Seville', 'Allante', 'Brougham', 'Catera', 'CTS', 'DE Ville', 'Eldorado', 'Escalade', 'Evoq', 'LSE',
            'SRX', 'Vizon', 'XLR', 'STS', 'DTS', 'Fleetwood', 'CTS-V Coupe', 'Cimarron', 'Convertible', 'BLS', 'XTS',
            'ATS', 'Eureka', 'ELR', 'XT5', 'CT6'
        ),
        'Citroen' => array(
            'Athena', 'AX', 'Berlingo пасс.', 'BX', 'C3', 'C5', 'C8', 'CX', 'Dyane', 'GSA', 'LNA', 'Reflex', 'Saxo',
            'Synergie', 'Visa', 'Xantia', 'XM', 'Xsara', 'Xsara Picasso', 'ZX', 'Jumpy пасс.', 'Jumper груз.', 'ID',
            'GS', 'Evasion', 'C6', 'C4', 'C2', 'C15', 'AMI', 'Acadiane', 'Oltcit', 'C1', 'Berlingo груз.',
            'Nemo груз.', 'C-Crosser', 'Grand C4 Picasso', 'C4 Picasso', 'Jumpy груз.', 'DS3', 'Nemo пасс.',
            'Jumper пасс.', 'C3 Picasso', 'CQ', 'DS4', 'DS5', '2CV', 'C-Elysee', 'Axel', 'C-Zero', 'C4 Cactus',
            'Rosalie', 'C4 Aircross', 'Traction Avant', 'Space Tourer'
        ),
        'Ford' => array(
            'Capri', 'Cortina', 'Cougar', 'Escort', 'Explorer', 'Fiesta', 'Focus', 'Fusion', 'Galaxy', 'Granada', 'KA',
            'Maverick', 'Mondeo', 'Orion', 'Probe', 'Puma', 'Scorpio', 'Streetka', 'Think', 'Consul', 'Econovan',
            'Excursion', 'Expedition', 'Ranger', 'Sport KA', 'Street KA', 'Taunus', 'Tempo', 'Tourneo Connect пасс.',
            'Transit груз.', 'Aerostar', 'Aspire', 'Contour', 'Crown Victoria', 'Econoline', 'Escape', 'Five Hundred',
            'Freestar', 'GT', 'Mustang Shelby', 'Taurus', 'Thunderbird', 'Courier', 'Windstar', 'Canyon', 'Edge',
            'C-Max', 'S-Max', 'Mustang', 'F-150', 'F-250', 'Transit Connect пасс.', 'Bronco', 'Kuga', 'Sierra', 'Flex',
            'Mustang GT', 'Transit Chassis', 'Transit Van', 'F-450', 'F-350', 'Otosan', 'Mercury', '3430', 'Telstar',
            'Laser', 'Willis', 'E-series', 'Transit пасс.', 'Transit Connect груз.', 'Tourneo Connect груз.',
            'Festiva', 'Fireline', 'Eafil', 'Galaxie', 'F-650', 'Eifel', 'Grand C-MAX', 'Ranch Wagon', 'Auborn',
            'Transit', 'Transit Connect', 'F-550', 'Diamant', 'Antara', 'Cabster', 'Escort van', 'Raptor', 'Cobra',
            'Model A', 'Fairlane', 'Gran Torino', 'LTD', 'Fairmont', 'Т', 'Freestyle', 'Falcon', 'B-Max',
            'Transit Custom', 'Tourneo Custom', 'V8', 'Model T', 'EcoSport', 'Tourneo Courier', 'F-Series',
            'Escort Express', 'Focus Electric', 'C-Max Energi', 'Transit Courier', 'Torino'
        ),
        'Honda' => array(
            'Accord', 'Aerodeck', 'Brio', 'Ballade', 'Civic', 'Concerto', 'CR-V', 'CRX', 'HR-V', 'Insight', 'Integra',
            'Jazz', 'Legend', 'Logo', 'NSX', 'Prelude', 'Quintet', 'S2000', 'Shuttle', 'Stream', 'Avancier', 'Capa',
            'City', 'Domani', 'Element', 'F-mx', 'FIT', 'Fit Aria', 'FR-V', 'Inspire', 'Lagreat', 'Life', 'Mobilio',
            'Odyssey', 'Orthia', 'Partner', 'Passport', 'Pilot', 'Saber', 'Sm-X', 'Stepwgn', 'That S', 'Torneo',
            'Vamos', 'Vigor', 'Ridgeline', 'Accord Tourer', 'Crosstour', 'CR-Z', 'VLX', 'Acty', 'Rafaga', 'Beat',
            'Eve', 'Elysion', 'Freed',
        ),
        'Jeep' => array(
            'Cherokee', 'Grand Cherokee', 'Wrangler', 'CJ', 'Liberty', 'Patriot', 'Compass', 'Commander', 'Willys',
            'Renegade', 'Comanche'
        ),
        'Mitsubishi' => array(
            '3000 GT', 'Carisma', 'Celeste', 'Challenger', 'Colt', 'Cordia', 'FTO', 'Galant', 'Lancer', 'Sapporo',
            'Shogun', 'Shogun Pinin', 'Shogun Sport', 'Sigma', 'Space Runner', 'Space Star', 'Space Wagon', 'Starion',
            'Tredia', 'Aspire', 'Chariot', 'Debonair', 'Diamante', 'Dingo', 'Dion', 'Eclipse', 'EK Wagon', 'Emeraude',
            'Endeavor', 'Grandis', 'GTO', 'Jeep', 'L 200', 'L 300 пасс.', 'L 400 пасс.', 'Legnum', 'Libero', 'Minica',
            'Mirage', 'Outlander', 'Pajero', 'Pistachio', 'Proudia', 'RVR', 'Santamo', 'Space Gear', 'Toppo',
            'Town Box', 'Montero', 'Eterna', 'Prestij', 'Nativa', 'Lancer X', 'Lancer Evolution', 'Outlander XL',
            'Pajero Sport', 'Pajero Wagon', 'Lancer X Sportback', 'Lanser Sportback', 'Eclipse USA', 'Delica', 'Virage',
            'Raider', 'ASX', 'Lancer X Ralliart', 'Ralli Art', 'L 400 груз.', 'L 300 груз.', 'Proton', 'Magna',
            'i-MiEV', 'Pajero Pinin', 'Galloper', 'Attrage', 'Minicab', 'Outlander PHEV', 'Airtrek', 'Axia ES',
            'Xpander', 'Eclipse Cross', 'Xpander Cross',
        ),
        'Peugeot' => array(
            '104', '106', '205', '206', '206 SW', '304', '305', '306', '306 Sedan', '307', '309', '405', '406', '504',
            '505', '604', '605', '607', '806', '807', 'Partner пасс.', '204', '407', 'Expert груз.', 'Boxer груз.',
            '404', 'Pars', 'Karsan', '207', '308', '107', 'G 5', '4007', 'Scenic', 'Bipper пасс.',
            '107 Hatchback (3d)', '107 Hatchback (5d)', '206 Sedan', '206 Hatchback (3d)', '206 Hatchback (5d)',
            '207 Hatchback (3d)', '207 Hatchback (5d)', '308 Hatchback (3d)', '308 Hatchback (5d)', '407 Coupe',
            '407 Sedan', '407 SW', 'RCZ', 'Boxer пасс.', 'Bipper груз.', 'Expert пасс.', 'Partner груз.', '3008',
            '308 SW', '308 CC', '307 CC', 'Boxer', '117', '508', '1007', '4008', '5008', '203', '308 Sportium', '403',
            '408', 'Ranch', '301', '208', 'P4', '208 Hatchback (5d)', '208 GTI', 'BB1', '2008', '508 RXH', 'iOn',
            '108', '206 СС', 'Traveller', '207 CC'
        )
    );
}
