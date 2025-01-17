using System.Configuration;
using Microsoft.EntityFrameworkCore;
using NELpizza.Model;

namespace NELpizza.Databases
{
    internal class AppDbContext : DbContext
    {
        public DbSet<Klant> Klants { get; set; }
        public DbSet<Bestelling> Bestellings { get; set; }
        public DbSet<Bestelregel> Bestelregels { get; set; }
        public DbSet<Pizza> Pizzas { get; set; }
        public DbSet<Ingredient> Ingredienten { get; set; }
        public DbSet<IngredientPizza> IngredientPizzas { get; set; }

        protected override void OnConfiguring(DbContextOptionsBuilder optionsBuilder)
        {
            if (!optionsBuilder.IsConfigured)
            {
                string connStr = ConfigurationManager.ConnectionStrings["MyConnStr"].ConnectionString;
                optionsBuilder.UseMySQL(connStr);
            }
        }

        protected override void OnModelCreating(ModelBuilder modelBuilder)
        {
            // IngredientPizza Pivot Table
            modelBuilder.Entity<IngredientPizza>()
                .HasKey(ip => new { ip.IngredientId, ip.PizzaId });

            modelBuilder.Entity<IngredientPizza>()
                .HasOne(ip => ip.Ingredient)
                .WithMany(i => i.Pizzas)
                .HasForeignKey(ip => ip.IngredientId)
                .OnDelete(DeleteBehavior.Cascade);

            modelBuilder.Entity<IngredientPizza>()
                .HasOne(ip => ip.Pizza)
                .WithMany(p => p.Ingredienten)
                .HasForeignKey(ip => ip.PizzaId)
                .OnDelete(DeleteBehavior.Cascade);

            // Bestelregel Relationships
            modelBuilder.Entity<Bestelregel>()
                .HasOne(br => br.Pizza)
                .WithMany()
                .HasForeignKey(br => br.PizzaId)
                .OnDelete(DeleteBehavior.Cascade);

            modelBuilder.Entity<Bestelregel>()
                .HasOne(br => br.Bestelling)
                .WithMany(b => b.Bestelregels)
                .HasForeignKey(br => br.BestellingId)
                .OnDelete(DeleteBehavior.Cascade);

            // Bestelling and Klant Relationship
            modelBuilder.Entity<Bestelling>()
                .HasOne(b => b.Klant)
                .WithMany(k => k.Bestellingen)
                .HasForeignKey(b => b.KlantId)
                .OnDelete(DeleteBehavior.Cascade);

            // Bestelling and Pizza Relationship
            modelBuilder.Entity<Bestelling>()
                .HasOne(b => b.Pizza)
                .WithMany()
                .HasForeignKey(b => b.PizzaId)
                .OnDelete(DeleteBehavior.Restrict);

            // Pizza Model Configuration
            modelBuilder.Entity<Pizza>()
                .Property(p => p.Prijs)
                .HasColumnType("DECIMAL(8,2)");

            // Ingredient Model Configuration
            modelBuilder.Entity<Ingredient>()
                .Property(i => i.Prijs)
                .HasColumnType("DECIMAL(8,2)");

            // Enum Configuration
            modelBuilder.Entity<Bestelling>()
                .Property(b => b.Status)
                .HasConversion<string>();
            modelBuilder.Entity<Bestelregel>()
                .Property(br => br.Afmeting)
                .HasConversion<string>();
        }

        public static void InitializeDatabase()
        {
            using (var context = new AppDbContext())
            {
                try
                {
                    // Drop the database (if needed during development)
                    //context.Database.EnsureDeleted();

                    // Create the database
                    context.Database.EnsureCreated();

                    // Seed the database
                    // DatabaseSeeder.Seed(context);
                    // KlantsTableSeeder.Seed(context);
                }
                catch (Exception ex)
                {
                    throw new InvalidOperationException($"Database initialization failed: {ex.Message}", ex);
                }
            }
        }
    }
}