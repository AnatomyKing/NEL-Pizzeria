using System;
using System.Collections.Generic;
using System.Linq;
using NELpizza.Model;
using NELpizza.Databases;

namespace NELpizza.Seeders
{
    internal static class DatabaseSeeder
    {
        internal static void Seed(AppDbContext context)
        {
                context.Database.EnsureCreated();

                // Seed First Half of Klants
                if (!context.Klants.Any())
                {
                    var klants = new List<Klant>
                {
                    new Klant
                    {
                        Naam = "Alice Wonderland",
                        Adres = "1 Queen's Lane",
                        Woonplaats = "Utrecht",
                        Telefoonnummer = "0612345671",
                        Emailadres = "alice@example.com"
                    },
                    new Klant
                    {
                        Naam = "Bob Builder",
                        Adres = "2 Hammer Street",
                        Woonplaats = "Eindhoven",
                        Telefoonnummer = "0612345672",
                        Emailadres = "bob@example.com"
                    }
                };
                    context.Klants.AddRange(klants);
                    context.SaveChanges();
                }

                // Seed First Half of Pizzas
                if (!context.Pizzas.Any())
                {
                    var pizzas = new List<Pizza>
                {
                    new Pizza { Naam = "Veggie Delight" },
                    new Pizza { Naam = "BBQ Chicken" }
                };
                    context.Pizzas.AddRange(pizzas);
                    context.SaveChanges();
                }

                // Seed First Half of Ingredients
                if (!context.Ingredienten.Any())
                {
                    var ingredients = new List<Ingredient>
                {
                    new Ingredient { Naam = "Mushrooms", Prijs = 1.10M },
                    new Ingredient { Naam = "Chicken", Prijs = 2.50M }
                };
                    context.Ingredienten.AddRange(ingredients);
                    context.SaveChanges();
                }

                // Seed First Half of Bestellings
                if (!context.Bestellings.Any())
                {
                    var bestellings = new List<Bestelling>
                {
                    new Bestelling
                    {
                        Datum = DateTime.UtcNow.AddDays(-3),
                        Status = "initieel",
                        KlantId = 1
                    }
                };
                    context.Bestellings.AddRange(bestellings);
                    context.SaveChanges();
                }

                // Seed First Half of Bestelregels
                if (!context.Bestelregels.Any())
                {
                    var bestelregels = new List<Bestelregel>
                {
                    new Bestelregel
                    {
                        Aantal = 1, Afmeting = "klein", PizzaId = 1, BestellingId = 1, BestellingPizzaId = 2001
                    }
                };
                    context.Bestelregels.AddRange(bestelregels);
                    context.SaveChanges();
                }
            }
        }
    }
