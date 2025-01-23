using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;

namespace NELpizza.Model
{
    [Table("employees")]
    public class Employee
    {
        [Key]
        [DatabaseGenerated(DatabaseGeneratedOption.Identity)]
        [Column("id", TypeName = "BIGINT UNSIGNED")]
        public long Id { get; set; }

        [Column("naam", TypeName = "VARCHAR(255)")]
        [Required]
        public string Naam { get; set; } = string.Empty;

        [Column("functie", TypeName = "VARCHAR(255)")]
        [Required]
        public string Functie { get; set; } = string.Empty;

        [Column("telefoon", TypeName = "VARCHAR(20)")]
        [Required]
        public string Telefoon { get; set; } = string.Empty;

        [Column("email", TypeName = "VARCHAR(255)")]
        [Required]
        public string Email { get; set; } = string.Empty;

        [Column("adres", TypeName = "VARCHAR(191)")]
        [Required]
        public string Adres { get; set; } = string.Empty;

        [Column("woonplaats", TypeName = "VARCHAR(191)")]
        [Required]
        public string Woonplaats { get; set; } = string.Empty;

        [Column("created_at", TypeName = "TIMESTAMP")]
        public DateTime? CreatedAt { get; set; }

        [Column("updated_at", TypeName = "TIMESTAMP")]
        public DateTime? UpdatedAt { get; set; }
    }
}
