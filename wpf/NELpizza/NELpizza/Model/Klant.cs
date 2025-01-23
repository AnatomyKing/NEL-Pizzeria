using System.Collections.Generic;
using System.ComponentModel.DataAnnotations.Schema;
using System.ComponentModel.DataAnnotations;

namespace NELpizza.Model
{
    [Table("klants")]
    public class Klant
    {
        [Key]
        [DatabaseGenerated(DatabaseGeneratedOption.Identity)]
        [Column("id", TypeName = "BIGINT UNSIGNED")]
        public long Id { get; set; }

        [Column("naam", TypeName = "VARCHAR(191)")]
        [Required]
        public string Naam { get; set; } = string.Empty;

        [Column("emailadres", TypeName = "VARCHAR(191)")]
        [Required]
        public string Email { get; set; } = string.Empty;

        [Column("adres", TypeName = "VARCHAR(191)")]
        [Required]
        public string Adres { get; set; } = string.Empty;

        [Column("woonplaats", TypeName = "VARCHAR(191)")]
        [Required]
        public string Woonplaats { get; set; } = string.Empty;

        [Column("telefoonnummer", TypeName = "VARCHAR(191)")]
        [Required]
        public string Telefoonnummer { get; set; } = string.Empty;

        // Navigation property for orders
        public virtual ICollection<Bestelling> Bestellingen { get; set; } = new HashSet<Bestelling>();

        // **Added Navigation Property for KlantUsers**
        public virtual ICollection<KlantUser> KlantUsers { get; set; } = new HashSet<KlantUser>();
    }
}