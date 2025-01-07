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
            base.OnModelCreating(modelBuilder);

            // Many-to-Many Relationship for Pizza & Ingredients
            modelBuilder.Entity<IngredientPizza>()
                .HasKey(ip => new { ip.pizza_id, ip.ingredient_id });

            modelBuilder.Entity<IngredientPizza>()
                .HasOne(ip => ip.pizza)
                .WithMany(p => p.ingredienten)
                .HasForeignKey(ip => ip.pizza_id);

            modelBuilder.Entity<IngredientPizza>()
                .HasOne(ip => ip.ingredient)
                .WithMany(i => i.pizzas)
                .HasForeignKey(ip => ip.ingredient_id);

            // One-to-Many Relationships
            modelBuilder.Entity<Bestelregel>()
                .HasOne(br => br.pizza)
                .WithMany()
                .HasForeignKey(br => br.pizza_id);

            modelBuilder.Entity<Bestelregel>()
                .HasOne(br => br.bestelling)
                .WithMany(b => b.Bestelregels)
                .HasForeignKey(br => br.bestelling_id);

            modelBuilder.Entity<Bestelling>()
                .HasOne(b => b.klant)
                .WithMany(k => k.bestellingen)
                .HasForeignKey(b => b.klant_id);
        }

        public static void InitializeDatabase()
        {
            using (var context = new AppDbContext())
            {
                try
                {
                    // drop database
                    context.Database.EnsureDeleted();

                    // create database
                    //context.Database.EnsureCreated();
                }
                catch (Exception ex)
                {
                    throw new InvalidOperationException($"Database initialization failed: {ex.Message}", ex);
                }
            }
        }
    }
}