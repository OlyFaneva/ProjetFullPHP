<?php

namespace Tests\Feature;

use App\Models\Todo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TodoControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_fetch_all_todos()
    {
        // Création de 2 todos
        Todo::factory()->create(['content' => 'First Todo']);
        Todo::factory()->create(['content' => 'Second Todo']);

        // Envoi de la requête GET
        $response = $this->getJson('/api/all');

        // Vérification du statut de la réponse et du contenu
        $response->assertStatus(200);
        $response->assertJsonCount(2); // Vérifie qu'il y a 2 todos
        $response->assertJsonFragment(['content' => 'First Todo']);
        $response->assertJsonFragment(['content' => 'Second Todo']);
    }

    /** @test */
    public function it_can_fetch_single_todo()
    {
        // Création d'un todo
        $todo = Todo::factory()->create(['content' => 'Single Todo']);

        // Envoi de la requête GET pour récupérer un todo
        $response = $this->getJson('/api/all/' . $todo->id);

        // Vérification du statut de la réponse et du contenu
        $response->assertStatus(200);
        $response->assertJsonFragment(['content' => 'Single Todo']);
    }

    /** @test */
    public function it_can_delete_a_todo()
    {
        // Création d'un todo
        $todo = Todo::factory()->create(['content' => 'Todo to delete']);

        // Envoi de la requête DELETE pour supprimer un todo
        $response = $this->deleteJson('/api/suppr/' . $todo->id);

        // Vérification du statut de la réponse et du message
        $response->assertStatus(200);
        $response->assertJson(['message' => 'wep man izy']);
        $this->assertDatabaseMissing('todos', ['content' => 'Todo to delete']);
    }

    /** @test */
    public function it_can_update_a_todo()
    {
        // Création d'un todo
        $todo = Todo::factory()->create(['content' => 'Old Content']);

        // Envoi de la requête PUT pour mettre à jour un todo
        $response = $this->putJson('/api/updt/' . $todo->id, [
            'content' => 'Updated Content',
        ]);

        // Vérification du statut de la réponse et du message
        $response->assertStatus(200);
        $response->assertJson(['message' => 'nice shot mon pote']);
        $this->assertDatabaseHas('todos', ['content' => 'Updated Content']);
    }

    /** @test */
    public function it_can_create_a_todo()
    {
        // Données du payload
        $payload = [
            'content' => 'Test Todo content',
        ];

        // Envoi de la requête POST pour créer un todo
        $response = $this->postJson('/api/store', $payload);

        // Vérification du statut de la réponse et du message
        $response->assertStatus(200);
        $response->assertJson(['message' => 'cool mo pote']);
        $this->assertDatabaseHas('todos', ['content' => 'Test Todo content']);
    }

    /** @test */
    public function it_fails_validation_when_creating_a_todo_without_content()
    {
        // Envoi de la requête POST sans le champ 'content'
        $response = $this->postJson('/api/store', []);

        // Vérification du statut de la réponse et des erreurs de validation
        $response->assertStatus(422);
        $response->assertJson([
            'message' => [
                'content' => ['The content field is required.'],
            ],
        ]);
    }
}
