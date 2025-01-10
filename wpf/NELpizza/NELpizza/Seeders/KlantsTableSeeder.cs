using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using NELpizza.Databases;
using NELpizza.Model;

namespace NELpizza.Seeders
{
    internal static class KlantsTableSeeder
    {
        public static void Seed(AppDbContext context)
        {
            // A list of Klant objects you want to insert
            var klants = new List<Klant>
            {
                    new Klant
                    {
                        Naam = "Csharp Man1",
                        Adres = "123 Reggae Road",
                        Woonplaats = "Jamaicatown",
                        Telefoonnummer = "9876543210",
                        Emailadres = "bob.marley@example.com"
                    },
                    new Klant
                    {
                        Naam = "Csharp Man2",
                        Adres = "456 Snoopy Street",
                        Woonplaats = "Peanutsville",
                        Telefoonnummer = "5556667777",
                        Emailadres = "charlie.brown@example.com"
                    },
                };

                // Add to database
                context.Klants.AddRange(klants);

                // Save changes
                context.SaveChanges();
            }
        }
    }
