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
        public string Telefoon { get; set; } = string.Empty;

        [Column("email", TypeName = "VARCHAR(255)")]
        [Required]
        public string Email { get; set; } = string.Empty;
    }
}
