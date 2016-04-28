<?php

/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2014-2016 Spomky-Labs
 *
 * This software may be modified and distributed under the terms
 * of the MIT license.  See the LICENSE file for details.
 */

namespace OAuth2\Test;

use AESGCM\AESGCM;

class IEEE802Test extends \PHPUnit_Framework_TestCase
{
    /**
     * @see http://www.ieee802.org/1/files/public/docs2011/bn-randall-test-vectors-0511-v1.pdf
     *
     * @dataProvider dataVectors
     */
    public function testVectors($K, $P, $A, $IV, $expected_C, $expected_T)
    {
        list ($C, $T) = AESGCM::encrypt($K, $IV, $P, $A);

        $this->assertEquals($C, $expected_C);
        $this->assertEquals($T, $expected_T);
        
        $computed_P = AESGCM::decrypt($K, $IV, $C, $A, $T);

        $this->assertEquals($P, $computed_P);
    }

    public function dataVectors()
    {
        return [
            [
                hex2bin('AD7A2BD03EAC835A6F620FDCB506B345'), // K
                null, // P
                hex2bin('D609B1F056637A0D46DF998D88E5222AB2C2846512153524C0895E8108000F101112131415161718191A1B1C1D1E1F202122232425262728292A2B2C2D2E2F30313233340001'), // A
                hex2bin('12153524C0895E81B2C28465'), // IV
                null, // Expected C
                hex2bin('F09478A9B09007D06F46E9B6A1DA25DD'), // Expected T
            ],
            [
                hex2bin('E3C08A8F06C6E3AD95A70557B23F75483CE33021A9C72B7025666204C69C0B72'), // K
                null, // P
                hex2bin('D609B1F056637A0D46DF998D88E5222AB2C2846512153524C0895E8108000F101112131415161718191A1B1C1D1E1F202122232425262728292A2B2C2D2E2F30313233340001'), // A
                hex2bin('12153524C0895E81B2C28465'), // IV
                null, // Expected C
                hex2bin('2F0BC5AF409E06D609EA8B7D0FA5EA50'), // Expected T
            ],
            [
                hex2bin('AD7A2BD03EAC835A6F620FDCB506B345'), // K
                hex2bin('08000F101112131415161718191A1B1C1D1E1F202122232425262728292A2B2C2D2E2F303132333435363738393A0002'), // P
                hex2bin('D609B1F056637A0D46DF998D88E52E00B2C2846512153524C0895E81'), // A
                hex2bin('12153524C0895E81B2C28465'), // IV
                hex2bin('701AFA1CC039C0D765128A665DAB69243899BF7318CCDC81C9931DA17FBE8EDD7D17CB8B4C26FC81E3284F2B7FBA713D'), // Expected C
                hex2bin('4F8D55E7D3F06FD5A13C0C29B9D5B880'), // Expected T
            ],
            [
                hex2bin('E3C08A8F06C6E3AD95A70557B23F75483CE33021A9C72B7025666204C69C0B72'), // K
                hex2bin('08000F101112131415161718191A1B1C1D1E1F202122232425262728292A2B2C2D2E2F303132333435363738393A0002'), // P
                hex2bin('D609B1F056637A0D46DF998D88E52E00B2C2846512153524C0895E81'), // A
                hex2bin('12153524C0895E81B2C28465'), // IV
                hex2bin('E2006EB42F5277022D9B19925BC419D7A592666C925FE2EF718EB4E308EFEAA7C5273B394118860A5BE2A97F56AB7836'), // Expected C
                hex2bin('5CA597CDBB3EDB8D1A1151EA0AF7B436'), // Expected T
            ],
            [
                hex2bin('071B113B0CA743FECCCF3D051F737382'), // K
                null, // P
                hex2bin('E20106D7CD0DF0761E8DCD3D88E5400076D457ED08000F101112131415161718191A1B1C1D1E1F202122232425262728292A2B2C2D2E2F303132333435363738393A0003'), // A
                hex2bin('F0761E8DCD3D000176D457ED'), // IV
                null, // Expected C
                hex2bin('0C017BC73B227DFCC9BAFA1C41ACC353'), // Expected T
            ],
            [
                hex2bin('691D3EE909D7F54167FD1CA0B5D769081F2BDE1AEE655FDBAB80BD5295AE6BE7'), // K
                null, // P
                hex2bin('E20106D7CD0DF0761E8DCD3D88E5400076D457ED08000F101112131415161718191A1B1C1D1E1F202122232425262728292A2B2C2D2E2F303132333435363738393A0003'), // A
                hex2bin('F0761E8DCD3D000176D457ED'), // IV
                null, // Expected C
                hex2bin('35217C774BBC31B63166BCF9D4ABED07'), // Expected T
            ],
            [
                hex2bin('071B113B0CA743FECCCF3D051F737382'), // K
                hex2bin('08000F101112131415161718191A1B1C1D1E1F202122232425262728292A2B2C2D2E2F30313233340004'), // P
                hex2bin('E20106D7CD0DF0761E8DCD3D88E54C2A76D457ED'), // A
                hex2bin('F0761E8DCD3D000176D457ED'), // IV
                hex2bin('13B4C72B389DC5018E72A171DD85A5D3752274D3A019FBCAED09A425CD9B2E1C9B72EEE7C9DE7D52B3F3'), // Expected C
                hex2bin('D6A5284F4A6D3FE22A5D6C2B960494C3'), // Expected T
            ],
            [
                hex2bin('691D3EE909D7F54167FD1CA0B5D769081F2BDE1AEE655FDBAB80BD5295AE6BE7'), // K
                hex2bin('08000F101112131415161718191A1B1C1D1E1F202122232425262728292A2B2C2D2E2F30313233340004'), // P
                hex2bin('E20106D7CD0DF0761E8DCD3D88E54C2A76D457ED'), // A
                hex2bin('F0761E8DCD3D000176D457ED'), // IV
                hex2bin('C1623F55730C93533097ADDAD25664966125352B43ADACBD61C5EF3AC90B5BEE929CE4630EA79F6CE519'), // Expected C
                hex2bin('12AF39C2D1FDC2051F8B7B3C9D397EF2'), // Expected T
            ],
            [
                hex2bin('013FE00B5F11BE7F866D0CBBC55A7A90'), // K
                null, // P
                hex2bin('84C5D513D2AAF6E5BBD2727788E523008932D6127CFDE9F9E33724C608000F101112131415161718191A1B1C1D1E1F202122232425262728292A2B2C2D2E2F303132333435363738393A3B3C3D3E3F0005'), // A
                hex2bin('7CFDE9F9E33724C68932D612'), // IV
                null, // Expected C
                hex2bin('217867E50C2DAD74C28C3B50ABDF695A'), // Expected T
            ],
            [
                hex2bin('83C093B58DE7FFE1C0DA926AC43FB3609AC1C80FEE1B624497EF942E2F79A823'), // K
                null, // P
                hex2bin('84C5D513D2AAF6E5BBD2727788E523008932D6127CFDE9F9E33724C608000F101112131415161718191A1B1C1D1E1F202122232425262728292A2B2C2D2E2F303132333435363738393A3B3C3D3E3F0005'), // A
                hex2bin('7CFDE9F9E33724C68932D612'), // IV
                null, // Expected C
                hex2bin('6EE160E8FAECA4B36C86B234920CA975'), // Expected T
            ],
            [
                hex2bin('013FE00B5F11BE7F866D0CBBC55A7A90'), // K
                hex2bin('08000F101112131415161718191A1B1C1D1E1F202122232425262728292A2B2C2D2E2F303132333435363738393A3B0006'), // P
                hex2bin('84C5D513D2AAF6E5BBD2727788E52F008932D6127CFDE9F9E33724C6'), // A
                hex2bin('7CFDE9F9E33724C68932D612'), // IV
                hex2bin('3A4DE6FA32191014DBB303D92EE3A9E8A1B599C14D22FB080096E13811816A3C9C9BCF7C1B9B96DA809204E29D0E2A7642'), // Expected C
                hex2bin('BFD310A4837C816CCFA5AC23AB003988'), // Expected T
            ],
            [
                hex2bin('83C093B58DE7FFE1C0DA926AC43FB3609AC1C80FEE1B624497EF942E2F79A823'), // K
                hex2bin('08000F101112131415161718191A1B1C1D1E1F202122232425262728292A2B2C2D2E2F303132333435363738393A3B0006'), // P
                hex2bin('84C5D513D2AAF6E5BBD2727788E52F008932D6127CFDE9F9E33724C6'), // A
                hex2bin('7CFDE9F9E33724C68932D612'), // IV
                hex2bin('110222FF8050CBECE66A813AD09A73ED7A9A089C106B959389168ED6E8698EA902EB1277DBEC2E68E473155A15A7DAEED4'), // Expected C
                hex2bin('A10F4E05139C23DF00B3AADC71F0596A'), // Expected T
            ],
            [
                hex2bin('88EE087FD95DA9FBF6725AA9D757B0CD'), // K
                null, // P
                hex2bin('68F2E77696CE7AE8E2CA4EC588E541002E58495C08000F101112131415161718191A1B1C1D1E1F202122232425262728292A2B2C2D2E2F303132333435363738393A3B3C3D3E3F404142434445464748494A4B4C4D0007'), // A
                hex2bin('7AE8E2CA4EC500012E58495C'), // IV
                null, // Expected C
                hex2bin('07922B8EBCF10BB2297588CA4C614523'), // Expected T
            ],
            [
                hex2bin('4C973DBC7364621674F8B5B89E5C15511FCED9216490FB1C1A2CAA0FFE0407E5'), // K
                null, // P
                hex2bin('68F2E77696CE7AE8E2CA4EC588E541002E58495C08000F101112131415161718191A1B1C1D1E1F202122232425262728292A2B2C2D2E2F303132333435363738393A3B3C3D3E3F404142434445464748494A4B4C4D0007'), // A
                hex2bin('7AE8E2CA4EC500012E58495C'), // IV
                null, // Expected C
                hex2bin('00BDA1B7E87608BCBF470F12157F4C07'), // Expected T
            ],
            [
                hex2bin('88EE087FD95DA9FBF6725AA9D757B0CD'), // K
                hex2bin('08000F101112131415161718191A1B1C1D1E1F202122232425262728292A2B2C2D2E2F303132333435363738393A3B3C3D3E3F404142434445464748490008'), // P
                hex2bin('68F2E77696CE7AE8E2CA4EC588E54D002E58495C'), // A
                hex2bin('7AE8E2CA4EC500012E58495C'), // IV
                hex2bin('C31F53D99E5687F7365119B832D2AAE70741D593F1F9E2AB3455779B078EB8FEACDFEC1F8E3E5277F8180B43361F6512ADB16D2E38548A2C719DBA7228D840'), // Expected C
                hex2bin('88F8757ADB8AA788D8F65AD668BE70E7'), // Expected T
            ],
            [
                hex2bin('4C973DBC7364621674F8B5B89E5C15511FCED9216490FB1C1A2CAA0FFE0407E5'), // K
                hex2bin('08000F101112131415161718191A1B1C1D1E1F202122232425262728292A2B2C2D2E2F303132333435363738393A3B3C3D3E3F404142434445464748490008'), // P
                hex2bin('68F2E77696CE7AE8E2CA4EC588E54D002E58495C'), // A
                hex2bin('7AE8E2CA4EC500012E58495C'), // IV
                hex2bin('BA8AE31BC506486D6873E4FCE460E7DC57591FF00611F31C3834FE1C04AD80B66803AFCF5B27E6333FA67C99DA47C2F0CED68D531BD741A943CFF7A6713BD0'), // Expected C
                hex2bin('2611CD7DAA01D61C5C886DC1A8170107'), // Expected T
            ],
        ];
    }
}