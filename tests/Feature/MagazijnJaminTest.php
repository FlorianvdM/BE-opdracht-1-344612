<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class MagazijnJaminTest extends TestCase
{
    /**
     * Test 1: Scherm Overzicht Magazijn Jamin toont alleen actieve producten gesorteerd op Barcode.
     */
    public function test_overzicht_magazijn_wordt_getoond(): void
    {
        $user = User::first() ?? User::factory()->create();

        $response = $this->actingAs($user)->get(route('magazijn.index'));

        $response->assertStatus(200);
        $response->assertSee('Overzicht Magazijn Jamin');
        $response->assertSee('Mintnopjes');
        $response->assertSee('Zoute Ruitjes');
        // Winegums is niet meer actief (IsActief = 0), dus staat niet in het overzicht
        $response->assertDontSee('Winegums');
    }

    /**
     * Test 2: User Story 1 - Scenario 01 (Mintnopjes heeft voorraad en toont leveranciergegevens).
     */
    public function test_leveringsinformatie_scenario_01_met_voorraad(): void
    {
        $user = User::first() ?? User::factory()->create();

        $response = $this->actingAs($user)->get(route('levering.show', 1));

        $response->assertStatus(200);
        $response->assertSee('LeveringsInformatie');
        $response->assertSee('Venco');
        $response->assertSee('Bert van Linge');
        $response->assertSee('Mintnopjes');
        $response->assertSee('Datum laatste levering');
    }

    /**
     * Test 3: User Story 1 - Scenario 02 (Winegums heeft geen voorraad en toont melding).
     */
    public function test_leveringsinformatie_scenario_02_geen_voorraad(): void
    {
        $user = User::first() ?? User::factory()->create();

        $response = $this->actingAs($user)->get(route('levering.show', 10));

        $response->assertStatus(200);
        $response->assertSee('Er is van dit product op dit moment geen voorraad aanwezig');
        $response->assertSee('meta http-equiv="refresh"', false);
    }

    /**
     * Test 4: User Story 2 - Scenario 01 (Zoute Ruitjes heeft allergenen en toont tabel).
     */
    public function test_allergeneninformatie_scenario_01_met_allergenen(): void
    {
        $user = User::first() ?? User::factory()->create();

        $response = $this->actingAs($user)->get(route('allergeen.show', 13));

        $response->assertStatus(200);
        $response->assertSee('Overzicht Allergenen');
        $response->assertSee('Zoute Ruitjes');
        $response->assertSee('Gluten');
        $response->assertSee('Lactose');
        $response->assertSee('Soja');
    }

    /**
     * Test 5: User Story 2 - Scenario 02 (Cola Flesjes heeft géén allergenen en toont melding).
     */
    public function test_allergeneninformatie_scenario_02_geen_allergenen(): void
    {
        $user = User::first() ?? User::factory()->create();

        $response = $this->actingAs($user)->get(route('allergeen.show', 5));

        $response->assertStatus(200);
        $response->assertSee('In dit product zitten geen stoffen die een allergische reactie kunnen veroorzaken');
        $response->assertSee('meta http-equiv="refresh"', false);
    }
}