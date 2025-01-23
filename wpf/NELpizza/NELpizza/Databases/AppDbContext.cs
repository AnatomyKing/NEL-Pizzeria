using System;
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
        public DbSet<User> Users { get; set; }
        public DbSet<KlantUser> KlantUsers { get; set; }
        public DbSet<BestelregelIngredient> BestelregelIngredienten { get; set; }

        protected override void OnConfiguring(DbContextOptionsBuilder optionsBuilder)
        {
            if (!optionsBuilder.IsConfigured)
            {
                // Use the connection string from app.config or web.config
                string connStr = ConfigurationManager.ConnectionStrings["MyConnStr"].ConnectionString;
                optionsBuilder.UseMySQL(connStr); // Use MySQL
            }
        }

        protected override void OnModelCreating(ModelBuilder modelBuilder)
        {
            ConfigureIngredientPizzaEntity(modelBuilder);
            ConfigureBestelregelIngredientEntity(modelBuilder);
            ConfigureKlantUserEntity(modelBuilder);
            ConfigureRelationships(modelBuilder);
            ConfigurePizzaEntity(modelBuilder);
            ConfigureIngredientEntity(modelBuilder);
            ConfigureEnums(modelBuilder);
        }

        private static void ConfigureIngredientPizzaEntity(ModelBuilder modelBuilder)
        {
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
        }

        private static void ConfigureBestelregelIngredientEntity(ModelBuilder modelBuilder)
        {
            modelBuilder.Entity<BestelregelIngredient>()
                .HasOne(bi => bi.Bestelregel)
                .WithMany(br => br.BestelregelIngredients)
                .HasForeignKey(bi => bi.BestelregelId)
                .OnDelete(DeleteBehavior.Cascade);

            modelBuilder.Entity<BestelregelIngredient>()
                .HasOne(bi => bi.Ingredient)
                .WithMany()
                .HasForeignKey(bi => bi.IngredientId)
                .OnDelete(DeleteBehavior.Cascade);
        }

        private static void ConfigureKlantUserEntity(ModelBuilder modelBuilder)
        {
            modelBuilder.Entity<KlantUser>()
                .HasKey(ku => new { ku.KlantId, ku.UserId });

            modelBuilder.Entity<KlantUser>()
                .HasOne(ku => ku.Klant)
                .WithMany()
                .HasForeignKey(ku => ku.KlantId)
                .OnDelete(DeleteBehavior.Cascade);

            modelBuilder.Entity<KlantUser>()
                .HasOne(ku => ku.User)
                .WithMany()
                .HasForeignKey(ku => ku.UserId)
                .OnDelete(DeleteBehavior.Cascade);
        }

        private static void ConfigureRelationships(ModelBuilder modelBuilder)
        {
            modelBuilder.Entity<Bestelling>()
                .HasOne(b => b.Klant)
                .WithMany(k => k.Bestellingen)
                .HasForeignKey(b => b.KlantId)
                .OnDelete(DeleteBehavior.Cascade);

            modelBuilder.Entity<Bestelregel>()
                .HasOne(br => br.Bestelling)
                .WithMany(b => b.Bestelregels)
                .HasForeignKey(br => br.BestellingId)
                .OnDelete(DeleteBehavior.Cascade);

            modelBuilder.Entity<Bestelregel>()
                .HasOne(br => br.Pizza)
                .WithMany()
                .HasForeignKey(br => br.PizzaId)
                .OnDelete(DeleteBehavior.Cascade);
        }

        private static void ConfigurePizzaEntity(ModelBuilder modelBuilder)
        {
            modelBuilder.Entity<Pizza>()
                .Property(p => p.Prijs)
                .HasColumnType("DECIMAL(8,2)");
        }

        private static void ConfigureIngredientEntity(ModelBuilder modelBuilder)
        {
            modelBuilder.Entity<Ingredient>()
                .Property(i => i.Prijs)
                .HasColumnType("DECIMAL(8,2)");
        }

        private static void ConfigureEnums(ModelBuilder modelBuilder)
        {
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
                    // Drop and recreate the database if needed (development only)
                    // context.Database.EnsureDeleted();
                    // context.Database.EnsureCreated();

                    // Optional: Seed the database with initial data
                    // DatabaseSeeder.Seed(context);
                }
                catch (Exception ex)
                {
                    throw new InvalidOperationException($"Database initialization failed: {ex.Message}", ex);
                }
            }
        }
    }
}
