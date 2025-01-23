using System;
using System.Configuration;
using Microsoft.EntityFrameworkCore;
using NELpizza.Model;

namespace NELpizza.Databases
{
    public class AppDbContext : DbContext
    {
        // DbSets for database tables
        public DbSet<Klant> Klants { get; set; }
        public DbSet<Employee> Employees { get; set; }
        public DbSet<Bestelling> Bestellings { get; set; }
        public DbSet<Bestelregel> Bestelregels { get; set; }
        public DbSet<Pizza> Pizzas { get; set; }
        public DbSet<Ingredient> Ingredienten { get; set; }
        public DbSet<IngredientPizza> IngredientPizzas { get; set; }
        public DbSet<User> Users { get; set; }
        public DbSet<KlantUser> KlantUsers { get; set; }
        public DbSet<BestelregelIngredient> BestelregelIngredienten { get; set; }

        // Configuring the database connection
        protected override void OnConfiguring(DbContextOptionsBuilder optionsBuilder)
        {
            if (!optionsBuilder.IsConfigured)
            {
                // Retrieve connection string from app.config or web.config
                string connStr = ConfigurationManager.ConnectionStrings["MyConnStr"].ConnectionString;
                optionsBuilder.UseMySQL(connStr); // Use MySQL as the database provider
            }
        }

        // Configuring entity relationships and other configurations
        protected override void OnModelCreating(ModelBuilder modelBuilder)
        {
            // Configure entities with methods
            ConfigureIngredientPizzaEntity(modelBuilder);
            ConfigureBestelregelIngredientEntity(modelBuilder);
            ConfigureKlantUserEntity(modelBuilder);
            ConfigureRelationships(modelBuilder);
            ConfigurePizzaEntity(modelBuilder);
            ConfigureIngredientEntity(modelBuilder);
            ConfigureEnums(modelBuilder);

            base.OnModelCreating(modelBuilder);
        }

        // Entity configuration for IngredientPizza
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

        // Entity configuration for BestelregelIngredient
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

        // Entity configuration for KlantUser
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

        // Configuring general relationships
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

        // Configure the Pizza entity
        private static void ConfigurePizzaEntity(ModelBuilder modelBuilder)
        {
            modelBuilder.Entity<Pizza>()
                .Property(p => p.Prijs)
                .HasColumnType("DECIMAL(8,2)");
        }

        // Configure the Ingredient entity
        private static void ConfigureIngredientEntity(ModelBuilder modelBuilder)
        {
            modelBuilder.Entity<Ingredient>()
                .Property(i => i.Prijs)
                .HasColumnType("DECIMAL(8,2)");
        }

        // Configure enums (e.g., order status, pizza sizes)
        private static void ConfigureEnums(ModelBuilder modelBuilder)
        {
            modelBuilder.Entity<Bestelling>()
                .Property(b => b.Status)
                .HasConversion<string>();

            modelBuilder.Entity<Bestelregel>()
                .Property(br => br.Afmeting)
                .HasConversion<string>();
        }

        // Method to initialize and optionally seed the database
        public static void InitializeDatabase()
        {
            using (var context = new AppDbContext())
            {
                try
                {
                    // Development-only database initialization
                    // Uncomment these lines during development
                    // context.Database.EnsureDeleted();
                    // context.Database.EnsureCreated();

                    // Optional: Add seeding logic here (e.g., initial data for employees, pizzas)
                }
                catch (Exception ex)
                {
                    throw new InvalidOperationException($"Database initialization failed: {ex.Message}", ex);
                }
            }
        }
    }
}
