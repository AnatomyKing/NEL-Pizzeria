using System.Configuration;
using Microsoft.EntityFrameworkCore;
using NELpizza.Model;

namespace NELpizza.Databases
{
    internal class AppDbContext : DbContext
    {
        public DbSet<Klant> Klanten { get; set; }
        public DbSet<Bestelling> Bestellingen { get; set; }
        public DbSet<Bestelregel> Bestelregels { get; set; }
        public DbSet<Pizza> Pizzas { get; set; }
        public DbSet<Ingredient> Ingredienten { get; set; }

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

            // Define relationships and table configurations here if needed
            modelBuilder.Entity<Bestelregel>()
                .HasOne(br => br.Pizza)
                .WithMany()
                .HasForeignKey(br => br.PizzaID);

            modelBuilder.Entity<Bestelregel>()
                .HasOne(br => br.Bestelling)
                .WithMany(b => b.Bestelregels)
                .HasForeignKey(br => br.BestellingID);

            modelBuilder.Entity<Bestelling>()
                .HasOne(b => b.Klant)
                .WithMany(k => k.Bestellingen)
                .HasForeignKey(b => b.KlantID);
        }

        public static void InitializeDatabase()
        {
            using (var context = new AppDbContext())
            {
                try
                {
                    // drop database
                    //context.Database.EnsureDeleted();

                    // create database
                    context.Database.EnsureCreated();
                }
                catch (Exception ex)
                {
                    throw new InvalidOperationException($"Database initialization failed: {ex.Message}", ex);
                }
            }
        }
    }
}