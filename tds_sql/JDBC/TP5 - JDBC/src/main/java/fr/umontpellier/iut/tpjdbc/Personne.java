package fr.umontpellier.iut.tpjdbc;

public class Personne {
	private int num;
	private String nom;
	private String prenom;
	private String nationalite;
	private int age;

	public Personne(int num, String nom, String prenom, String nationalite, int age) {
		this.num = num;
		this.nom = nom;
		this.prenom = prenom;
		this.nationalite = nationalite;
		this.age = age;
	}

	public int getNum() {
		return num;
	}

	public void setNum(int num) {
		this.num = num;
	}

	public String getNom() {
		return nom;
	}

	public void setNom(String nom) {
		this.nom = nom;
	}

	public String getPrenom() {
		return prenom;
	}

	public void setPrenom(String prenom) {
		this.prenom = prenom;
	}

	public String getNationalite() {
		return nationalite;
	}
	
	
	public void setNationalite(String nationalite) {
		this.nationalite = nationalite;
	}
	
	public int getAge() {
		return age;
	}

	public void setAge(int age) {
		this.age = age;
	}
}
